from enum import Enum, unique


@unique
class Environment(Enum):
    LOCAL = 1
    DEVELOPMENT = 2
    STAGING = 3
    PRODUCTION = 4


current_environment = Environment.DEVELOPMENT
