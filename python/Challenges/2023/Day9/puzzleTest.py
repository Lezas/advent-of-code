class PuzzleTest:
    def test_first_part():
        yield {'result': 114, 'test_input': """
0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45
"""
               }
        yield {'result': 114, 'test_input': """
8 7 6 5 4 3 2 1 0 -1 -2 -3 -4 -5 -6 -7 -8 -9 -10 -11 -12
"""
               }

    def test_second_part():
        yield {'result': 2, 'test_input': """
0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45
"""
               }

