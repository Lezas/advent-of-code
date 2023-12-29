class PuzzleTest:
    def test_first_part():
        yield {'result': 1, 'test_input': """
19, 13, 30 @ -2,  1, -2
18, 19, 22 @ -1, -1, -2
20, 25, 34 @ -2, -2, -4
12, 31, 28 @ -1, -2, -1
20, 19, 15 @  1, -5, -3
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

