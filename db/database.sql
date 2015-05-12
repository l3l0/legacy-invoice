DROP TABLE IF EXISTS invoice_items, invoices, users;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    vat VARCHAR(20),
    name VARCHAR(255),
    address VARCHAR(255)
);
CREATE TABLE invoices (
    id SERIAL PRIMARY KEY,
    invoice_number VARCHAR(150) NOT NULL,
    date_of_invoice TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sell_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    maturity_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    additional_info TEXT,
    seller_vat_number VARCHAR(20) NOT NULL,
    seller_name VARCHAR (255) NOT NULL,
    seller_address VARCHAR(255),
    buyer_vat_number VARCHAR(20) NOT NULL,
    buyer_name VARCHAR (255) NOT NULL,
    buyer_address VARCHAR(255),
    total_price NUMERIC(12, 2),
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE invoice_items (
    id SERIAL PRIMARY KEY,
    invoice_id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    quantity INTEGER NOT NULL,
    unit VARCHAR(150),
    net_price NUMERIC(12, 2) NOT NULL,
    vat NUMERIC NOT NULL,
    total_price NUMERIC(12, 2) NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id)
);
