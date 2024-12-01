class PuzzleTest:
    def test_first_part():
        yield {'result': 11, 'test_input': """
3   4
4   3
2   5
1   3
3   9
3   3
"""
               }

    def test_second_part():
        yield {'result': 31, 'test_input': """
3   4
4   3
2   5
1   3
3   9
3   3
        """
               }

