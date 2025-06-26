\c iamon;

CREATE TABLE users (
    user_id BIGSERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    passwd VARCHAR(255) NOT NULL,
    email VARCHAR(255)
);

CREATE TABLE toggles(
    toggle_id BIGSERIAL PRIMARY KEY,
    public_id UUID UNIQUE NOT NULL,
    private_id UUID UNIQUE NOT NULL,
    toggle_name VARCHAR(100) NOT NULL,
    toggle_description VARCHAR(400),
    toggle_state BOOLEAN NOT NULL DEFAULT FALSE,
    shutdown_date TIMESTAMP,
    turn_on_date TIMESTAMP,
    user_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE subscriptions(
    user_id INTEGER,
    toggle_id INTEGER,
    subscription_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, toggle_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (toggle_id) REFERENCES toggles(toggle_id) ON DELETE CASCADE
);