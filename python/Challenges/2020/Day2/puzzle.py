from itertools import combinations
import math

class Puzzle:
    def first_part(input_string: str):
        numbers = [int(a) for a in input_string.split('\n')]

        for pair in combinations(numbers, 2):
            if sum(pair) == 2020:
                return math.prod(pair)

    def second_part(input_string: str):
        numbers = [int(a) for a in input_string.split('\n')]

        for pair in combinations(numbers, 3):
            if sum(pair) == 2020:
                return math.prod(pair)
