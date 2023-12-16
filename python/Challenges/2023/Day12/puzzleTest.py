class PuzzleTest:
    def test_first_part():
        yield {'result': 21, 'test_input': """
???.### 1,1,3
.??..??...?##. 1,1,3
?#?#?#?#?#?#?#? 1,3,1,6
????.#...#... 4,1,1
????.######..#####. 1,6,5
?###???????? 3,2,1
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

