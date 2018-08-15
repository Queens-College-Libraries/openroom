import config

if config.current_environment == config.Environment.DEVELOPMENT:
    SQLALCHEMY_DATABASE_URI = "sqlite:///test.db"
