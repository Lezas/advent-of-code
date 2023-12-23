class PuzzleTest:
    def test_first_part():
#         yield {'result': 32000000, 'test_input': """
# broadcaster -> a, b, c
# %a -> b
# %b -> c
# %c -> inv
# &inv -> a
# """
#                }
        yield {'result': 11687500, 'test_input': """
broadcaster -> a
%a -> inv, con
&inv -> b
%b -> con
&con -> output
"""
               }

    def test_second_part():
        yield {'result': 281, 'test_input': """
two1nine
eightwothree
abcone2threexyz
xtwone3four
4nineeightseven2
zoneight234
7pqrstsixteen
        """
               }

