from cleo.application import Application
from Commands.run_puzzle_command import RunPuzzleCommand

application = Application()
application.add(RunPuzzleCommand())

if __name__ == "__main__":
    application.run()
