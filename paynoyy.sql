DROP DATABASE IF EXISTS paynoy;
CREATE DATABASE paynoy;
USE paynoy;

CREATE TABLE user (
    userid VARCHAR(12) NOT NULL PRIMARY KEY,
    full_name VARCHAR(40) NOT NULL,
    date_of_birth DATE NOT NULL,
    username VARCHAR(15) NOT NULL UNIQUE,
    age INT DEFAULT 0,
    citizenship VARCHAR(20) NOT NULL,
    address VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    email_address VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    passkey CHAR(4) NULL,
    sex CHAR(1) NOT NULL CHECK (sex IN ('M','F')),
    date_registered DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE budget_cycles (
    cycle_id VARCHAR(12) NOT NULL PRIMARY KEY,
    userid VARCHAR(12) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    cycle_name VARCHAR(20) NOT NULL,
    total_income DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_expense DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_savings DECIMAL(10,2) NOT NULL DEFAULT 0,
    remaining_budget DECIMAL(10,2) GENERATED ALWAYS AS (total_income - total_expense - total_savings) STORED,
    budget_remarks VARCHAR(150) DEFAULT 'Welcome! Start adding your budget.',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    rollover_status VARCHAR(10) DEFAULT 'NONE' CHECK (rollover_status IN ('NONE','SAVED','EXPENSE')),
    rollover_amount DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE,
    UNIQUE (userid, cycle_name)
);

DELIMITER $$

CREATE TRIGGER trg_cycle_name_before_insert
BEFORE INSERT ON budget_cycles
FOR EACH ROW
BEGIN
    SET NEW.cycle_name = UPPER(DATE_FORMAT(NEW.start_date, '%b%Y'));
END$$

DELIMITER ;

CREATE TABLE earnings (
    in_id VARCHAR(12) NOT NULL PRIMARY KEY,
    cycle_id VARCHAR(12) NOT NULL,
    income_source VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date_received DATE DEFAULT (CURDATE()),
    FOREIGN KEY (cycle_id) REFERENCES budget_cycles(cycle_id) ON DELETE CASCADE
);

CREATE TABLE expenses (
    out_id VARCHAR(12) NOT NULL PRIMARY KEY, 
    cycle_id VARCHAR(12) NOT NULL,
    category VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date_spent DATE DEFAULT (CURDATE()),
    FOREIGN KEY (cycle_id) REFERENCES budget_cycles(cycle_id) ON DELETE CASCADE
);

CREATE TABLE savings (
    savingsno VARCHAR(12) NOT NULL PRIMARY KEY, 
    userid VARCHAR(12) NOT NULL,
    bank VARCHAR(20) NOT NULL,
    description VARCHAR(30) NULL,
    savings_amount DECIMAL(10,2) NOT NULL DEFAULT 0, 
    interest_rate FLOAT DEFAULT 0,
    date_of_save DATE DEFAULT (CURDATE()), 
    interest_earned DECIMAL(10,2) GENERATED ALWAYS AS (ROUND((savings_amount * interest_rate)/100, 2)) STORED,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);

CREATE TABLE savings_transactions (
    trans_id VARCHAR(12) NOT NULL PRIMARY KEY,
    savingsno VARCHAR(12) NOT NULL,
    trans_type VARCHAR(10) NOT NULL CHECK (trans_type IN('DEPOSIT', 'WITHDRAWAL')),
    amount DECIMAL(10,2) NOT NULL,
    trans_date DATE DEFAULT (CURDATE()),
    FOREIGN KEY (savingsno) REFERENCES savings(savingsno) ON DELETE CASCADE
);

DELIMITER $$

-- USER TRIGGERS
CREATE TRIGGER trg_userid_before_insert
BEFORE INSERT ON user FOR EACH ROW
BEGIN
    DECLARE max_seq INT;
    SELECT IFNULL(MAX(CAST(SUBSTRING(userid, 4) AS UNSIGNED)), 0) INTO max_seq FROM user;
    SET NEW.userid = CONCAT('PN-', LPAD(max_seq + 1, 6, '0'));
END $$

CREATE TRIGGER trg_calculate_age_insert
BEFORE INSERT ON user FOR EACH ROW
BEGIN
    SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE());
END $$

-- BUDGET CYCLES TRIGGERS
CREATE TRIGGER trg_cycle_id_gen
BEFORE INSERT ON budget_cycles FOR EACH ROW
BEGIN
    DECLARE max_seq INT;
    SELECT IFNULL(MAX(CAST(SUBSTRING(cycle_id, 5) AS UNSIGNED)), 0) INTO max_seq FROM budget_cycles;
    SET NEW.cycle_id = CONCAT('CYC-', LPAD(max_seq + 1, 6, '0'));
END $$

CREATE TRIGGER trg_remarks_insert
BEFORE INSERT ON budget_cycles FOR EACH ROW
BEGIN
    SET NEW.budget_remarks = 'New cycle started. Good luck with your budgeting!';
END $$

CREATE TRIGGER trg_remarks_update
BEFORE UPDATE ON budget_cycles FOR EACH ROW
BEGIN
    DECLARE v_balance DECIMAL(10,2);
    SET v_balance = NEW.total_income - NEW.total_expense - NEW.total_savings;

    IF v_balance > 0 THEN
        SET NEW.budget_remarks = 'Good job! You have extra money. Why not save it?';
    ELSEIF v_balance < 0 THEN
        SET NEW.budget_remarks = 'Warning: You are overspending! You are in debt.';
    ELSE
        IF NEW.total_income = 0 THEN
             SET NEW.budget_remarks = 'No budget yet. Please add income.';
        ELSE
             SET NEW.budget_remarks = 'Perfect! Your budget is fully allocated.';
        END IF;
    END IF;
END $$

-- EARNINGS TRIGGERS
CREATE TRIGGER trg_in_id_gen
BEFORE INSERT ON earnings FOR EACH ROW
BEGIN
    DECLARE max_seq INT;
    SELECT IFNULL(MAX(CAST(SUBSTRING(in_id, 4) AS UNSIGNED)), 0) INTO max_seq FROM earnings;
    SET NEW.in_id = CONCAT('IN-', LPAD(max_seq + 1, 6, '0'));
END $$

CREATE TRIGGER trg_update_income_total
AFTER INSERT ON earnings FOR EACH ROW
BEGIN
    UPDATE budget_cycles SET total_income = total_income + NEW.amount WHERE cycle_id = NEW.cycle_id;
END $$

-- EXPENSES TRIGGERS
CREATE TRIGGER trg_out_id_gen
BEFORE INSERT ON expenses FOR EACH ROW
BEGIN
    DECLARE max_seq INT;
    SELECT IFNULL(MAX(CAST(SUBSTRING(out_id, 5) AS UNSIGNED)), 0) INTO max_seq FROM expenses;
    SET NEW.out_id = CONCAT('OUT-', LPAD(max_seq + 1, 6, '0'));
END $$

CREATE TRIGGER trg_update_expense_total
AFTER INSERT ON expenses FOR EACH ROW
BEGIN
    UPDATE budget_cycles SET total_expense = total_expense + NEW.amount WHERE cycle_id = NEW.cycle_id;
END $$

-- SAVINGS TRIGGERS
CREATE TRIGGER trg_savingsno_before_insert
BEFORE INSERT ON savings FOR EACH ROW
BEGIN
    DECLARE max_seq INT;
    SELECT IFNULL(MAX(CAST(SUBSTRING(savingsno, 6) AS UNSIGNED)), 0) INTO max_seq FROM savings;
    SET NEW.savingsno = CONCAT('SAVE-', LPAD(max_seq + 1, 6, '0'));
END $$

CREATE TRIGGER trg_trans_id_gen
BEFORE INSERT ON savings_transactions FOR EACH ROW
BEGIN
    DECLARE max_seq INT;
    SELECT IFNULL(MAX(CAST(SUBSTRING(trans_id, 5) AS UNSIGNED)), 0) INTO max_seq FROM savings_transactions;
    SET NEW.trans_id = CONCAT('TRN-', LPAD(max_seq + 1, 6, '0'));
END $$

CREATE TRIGGER trg_update_savings_balance
AFTER INSERT ON savings_transactions
FOR EACH ROW
BEGIN
    DECLARE v_userid VARCHAR(12);
    DECLARE v_active_cycle_id VARCHAR(12);

    SELECT userid INTO v_userid FROM savings WHERE savingsno = NEW.savingsno;

    SELECT cycle_id INTO v_active_cycle_id
    FROM budget_cycles
    WHERE userid = v_userid AND is_active = 1
    LIMIT 1;

    IF NEW.trans_type = 'DEPOSIT' THEN
        UPDATE savings 
        SET savings_amount = savings_amount + NEW.amount 
        WHERE savingsno = NEW.savingsno;
        
        IF v_active_cycle_id IS NOT NULL THEN
            UPDATE budget_cycles 
            SET total_savings = total_savings + NEW.amount 
            WHERE cycle_id = v_active_cycle_id;
        END IF;

    ELSEIF NEW.trans_type = 'WITHDRAWAL' THEN
        UPDATE savings 
        SET savings_amount = savings_amount - NEW.amount 
        WHERE savingsno = NEW.savingsno;
        
        IF v_active_cycle_id IS NOT NULL THEN
            UPDATE budget_cycles 
            SET total_savings = total_savings - NEW.amount 
            WHERE cycle_id = v_active_cycle_id;
        END IF;
    END IF;
END $$

CREATE TRIGGER trg_insert_savings
AFTER INSERT ON savings
FOR EACH ROW
BEGIN
    DECLARE v_active_cycle_id VARCHAR(12);

    SELECT cycle_id INTO v_active_cycle_id
    FROM budget_cycles
    WHERE userid = NEW.userid AND is_active = 1
    LIMIT 1;

    IF NEW.savings_amount > 0 AND v_active_cycle_id IS NOT NULL THEN
        UPDATE budget_cycles
        SET total_savings = total_savings + NEW.savings_amount
        WHERE cycle_id = v_active_cycle_id;
    END IF;
END$$

-- PROCEDURES
CREATE PROCEDURE AddSavingsTransaction (
    IN p_userid VARCHAR(12),
    IN p_bank_name VARCHAR(20),
    IN p_amount DECIMAL(10,2),
    IN p_trans_type VARCHAR(10),
    IN p_interest FLOAT,
    IN p_description VARCHAR(30)
)
BEGIN
    DECLARE v_savingsno VARCHAR(12);

    SELECT savingsno INTO v_savingsno
    FROM savings
    WHERE userid = p_userid AND bank = p_bank_name
    LIMIT 1;

    IF v_savingsno IS NULL THEN
        INSERT INTO savings (userid, bank, savings_amount, interest_rate, description)
        VALUES (
            p_userid, 
            p_bank_name,
            0, 
            p_interest, 
            IFNULL(p_description, CONCAT(p_bank_name, ' Account'))
        );
        
        SELECT savingsno INTO v_savingsno
        FROM savings
        WHERE userid = p_userid AND bank = p_bank_name
        ORDER BY savingsno DESC LIMIT 1;
    END IF;

    INSERT INTO savings_transactions (savingsno, trans_type, amount)
    VALUES (v_savingsno, p_trans_type, p_amount);
    
END $$

CREATE PROCEDURE CloseAndStartNewCycle (
    IN p_userid VARCHAR(12),
    IN p_rollover_decision VARCHAR(10),
    IN p_target_savingsno VARCHAR(12)
)
BEGIN
    DECLARE v_old_cycle_id VARCHAR(12);
    DECLARE v_old_cycle_name VARCHAR(20);
    DECLARE v_end_date DATE;
    DECLARE v_leftover DECIMAL(10,2);
    
    SELECT cycle_id, cycle_name, end_date, (total_income - total_expense - total_savings)
    INTO v_old_cycle_id, v_old_cycle_name, v_end_date, v_leftover
    FROM budget_cycles
    WHERE userid = p_userid AND is_active = 1
    LIMIT 1;

    IF v_leftover > 0 THEN
        IF p_rollover_decision = 'SAVED' AND p_target_savingsno IS NOT NULL THEN
            INSERT INTO savings_transactions (savingsno, trans_type, amount)
            VALUES (p_target_savingsno, 'DEPOSIT', v_leftover);
        END IF;
    END IF;

    UPDATE budget_cycles
    SET is_active = 0,
        rollover_status = p_rollover_decision,
        rollover_amount = IF(v_leftover > 0, v_leftover, 0)
    WHERE cycle_id = v_old_cycle_id;

    INSERT INTO budget_cycles (userid, start_date, end_date, is_active)
    VALUES (p_userid, DATE_ADD(v_end_date, INTERVAL 1 DAY), DATE_ADD(v_end_date, INTERVAL 30 DAY), 1);

END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER trg_delete_savings_convert_to_expense
AFTER DELETE ON savings
FOR EACH ROW
BEGIN
    DECLARE v_active_cycle_id VARCHAR(12);

    SELECT cycle_id INTO v_active_cycle_id
    FROM budget_cycles
    WHERE userid = OLD.userid AND is_active = 1
    LIMIT 1;

    IF v_active_cycle_id IS NOT NULL AND OLD.savings_amount > 0 THEN
        
        UPDATE budget_cycles
        SET total_savings = total_savings - OLD.savings_amount
        WHERE cycle_id = v_active_cycle_id;

        INSERT INTO expenses (out_id, cycle_id, category, amount, date_spent)
        VALUES ('', v_active_cycle_id, CONCAT('Deleted: ', OLD.bank), OLD.savings_amount, CURDATE());

    END IF;
END$$

DELIMITER ;

-- DELETE
DELIMITER $$
CREATE TRIGGER trg_delete_income
AFTER DELETE ON earnings
FOR EACH ROW
BEGIN
    UPDATE budget_cycles 
    SET total_income = total_income - OLD.amount 
    WHERE cycle_id = OLD.cycle_id;
END$$

DELIMITER ;

DELIMITER $$
CREATE TRIGGER trg_delete_expense
AFTER DELETE ON expenses
FOR EACH ROW
BEGIN
    UPDATE budget_cycles 
    SET total_expense = total_expense - OLD.amount 
    WHERE cycle_id = OLD.cycle_id;
END$$

DELIMITER ;

-- EDIT / UPDATE
DELIMITER $$

CREATE TRIGGER trg_income_edit
AFTER UPDATE ON earnings
FOR EACH ROW
BEGIN
    UPDATE budget_cycles 
    SET total_income = total_income - OLD.amount + NEW.amount
    WHERE cycle_id = OLD.cycle_id;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER trg_expense_edit
AFTER UPDATE ON expenses
FOR EACH ROW
BEGIN
    UPDATE budget_cycles 
    SET total_expense = total_expense - OLD.amount + NEW.amount
    WHERE cycle_id = OLD.cycle_id;
END$$

DELIMITER ;

-- INSERT INTO user (userid, full_name, date_of_birth, username, citizenship, address, phone_number, email_address, password, sex, payday_cutoff) 
-- VALUES (NULL, 'Kelia Audrey', '2005-05-15', 'kasgamayo', 'FILIPINO', 'Quezon City', '09393534330', 'kagamayo@gmail.com', '1234', 'F', 31);

INSERT INTO budget_cycles (cycle_id, userid, start_date, end_date) 
VALUES (NULL, 'PN-000001', '2025-12-01', '2025-12-31');

INSERT INTO earnings (in_id, cycle_id, income_source, amount) 
VALUES (NULL, 'CYC-000001', 'Allowance', 80000);

INSERT INTO expenses (out_id, cycle_id, category, amount) 
VALUES (NULL, 'CYC-000001', 'PC', 20000);

CALL AddSavingsTransaction(
    'PN-000001', 'BDO', 10000, 'DEPOSIT', 0.23, NULL
);

CALL AddSavingsTransaction(
    'PN-000001', 'BDO', 5000, 'WITHDRAWAL', 0.23, NULL
);

CALL AddSavingsTransaction(
    'PN-000001', 'BPI', 10000, 'DEPOSIT', 1234, 0.21, 'Concert'
);

INSERT INTO `paynoy`.`savings_transactions` (`savingsno`, `trans_type`, `amount`) VALUES ('SAVE-000002', 'WITHDRAWAL', '5000');
INSERT INTO `paynoy`.`savings_transactions` (`savingsno`, `trans_type`, `amount`) VALUES ('SAVE-000002', 'DEPOSIT', '5000');

SELECT * from user;
SELECT * from budget_cycles;
SELECT * from earnings;
SELECT * from expenses;
SELECT * from savings;
SELECT * from savings_transactions;

