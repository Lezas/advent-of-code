class PuzzleTest:
    def test_first_part():
        yield {'result': 52, 'test_input': """
HASH
"""
               }
        yield {'result': 1320, 'test_input': """
rn=1,cm-,qp=3,cm=2,qp-,pc=4,ot=9,ab=5,pc-,pc=6,ot=7
"""
               }

    def test_second_part():
        yield {'result': 145, 'test_input': """
rn=1,cm-,qp=3,cm=2,qp-,pc=4,ot=9,ab=5,pc-,pc=6,ot=7
        """
               }

