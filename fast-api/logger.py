import logging

def initialize_logging():
    logger = logging.getLogger()
    logger.setLevel(logging.INFO)

    formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')

    # StreamHandler for stdout (visible in Docker logs)
    sh = logging.StreamHandler()
    sh.setFormatter(formatter)
    logger.addHandler(sh)

    # Optional: FileHandler for file logging
    fh = logging.FileHandler('data.log', mode='a')
    fh.setFormatter(formatter)
    logger.addHandler(fh)