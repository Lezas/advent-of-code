class PuzzleTest:
    def test_first_part():
        yield {'result': 405, 'test_input': """
#.##..##.
..#.##.#.
##......#
##......#
..#.##.#.
..##..##.
#.#.##.#.

#...##..#
#....#..#
..##..###
#####.##.
#####.##.
..##..###
#....#..#
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

