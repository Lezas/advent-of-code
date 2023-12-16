from itertools import combinations
import math
import re


def distance(l: str, r: str) -> int:
    return sum(a != b for a, b in zip(l, r))

class Puzzle:

    def count_reflection_index(self, map: list[str]):
        for id in range(len(map)):
            if id == 0:
                continue

            if sum(distance(l, r) for l, r in zip(reversed(map[:id]), map[id:])) == 1:
                return id
        return 0

    def first_part(self, input_string: str):
        maps = [a.split('\n') for a in input_string.split('\n\n')]
        print(maps)
        print([a for a in reversed(maps)])
        suma = 0
        for map in maps:
            if id := self.count_reflection_index(map):
                suma += id * 100
                continue

            if id := self.count_reflection_index(list(zip(*map))):
                print('vertical', '\n'.join(map), id)
                suma += id

        return suma

    def second_part(self, input_string: str):

        return suma
