from cleo.commands.command import Command
from cleo.helpers import argument, option
from pathlib import Path
import datetime


class RunPuzzleCommand(Command):
    name = "puzzle"
    description = "Execute puzzle"
    arguments = [
        argument(
            "day",
            description="What day puzzle to run?",
        ),
        argument(
            "part",
            description="What part of puzzle to run? (1|2)",
            optional=True,
            default=1
        ),
        argument(
            "year",
            description="What year puzzle to run? Default - current year",
            optional=True,
            default=datetime.date.today().year
        )
    ]
    options = [
        option(
            long_name="test",
            short_name="t",
            description="Run Tests?",
            value_required=False,
        )
    ]

    def handle(self):
        year = self.argument("year")
        day = self.argument("day")
        part = self.argument("part")
        run_tests = self.option("test")
        module = __import__("Challenges.%s.Day%s.puzzle" % (year, day), fromlist=['puzzle'])
        my_class = getattr(module, 'Puzzle')
        obj = my_class()

        if run_tests:
            test_module = __import__("Challenges.%s.Day%s.puzzleTest" % (year, day), fromlist=['puzzleTest'])
            test_class = getattr(test_module, 'PuzzleTest')

            if part == "1":
                test_cases = test_class.test_first_part()
            else:
                test_cases = test_class.test_second_part()

            for test_input in test_cases:
                if part == "1":
                    result = str(obj.first_part(test_input["test_input"].strip()))
                elif part == "2":
                    result = str(obj.second_part(test_input["test_input"].strip()))

                if result != str(test_input["result"]):
                    self.line("FAIL: " + str(test_input["result"]) + " != " + result)
                else:
                    self.line("SUCC: " + str(test_input["result"]) + " == " + result)
        else:
            inputFile = open(str(Path.cwd()) + "/Challenges/%s/Day%s/input.txt" % (year, day), 'r')
            contents = inputFile.read()
            inputFile.close()
            if part == "1":
                result = str(obj.first_part(contents))
            elif part == "2":
                result = str(obj.second_part(contents))
            self.line(result)
