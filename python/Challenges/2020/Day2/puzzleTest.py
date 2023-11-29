class PuzzleTest:
    def test_first_part():
        yield {'result': 2, 'test_input': """
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
"""
               }

    def test_second_part():
        yield {'result': 241861950, 'test_input': """
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
        """
               }

