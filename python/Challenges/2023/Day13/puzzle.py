from itertools import combinations
import math
import re


def find_reflection_in_string(input_string):
    length = len(input_string)

    for start_pos in range(length - 1):
        for refl_len in range(1, min(length - start_pos, start_pos + 2)):
            if input_string[start_pos:start_pos + refl_len] == input_string[-refl_len:][::-1]:
                print(input_string, input_string[start_pos:start_pos + refl_len], input_string[-refl_len:][::-1])
                return True, start_pos, refl_len

    return False, 0, 0


class Puzzle:

    def first_part(self, input_string: str):
        maps = [a.split('\n') for a in input_string.split('\n\n')]
        print(maps)

        for map in maps:
            # print([''.join(row) for row in zip(*map)])
            mirror_keys = []
            print(map)
            # print(len(map))
            for row_key in range(2, len(map) - 2):
                print('comparing:', row_key)
                print(map[row_key], map[row_key + 1])
                print(map[row_key - 1], map[row_key + 2])
                if (map[row_key] == map[row_key + 1] and
                        map[row_key - 1] == map[row_key + 2]):
                    mirror_keys.append(row_key)
            print('keys:', mirror_keys)
        return suma

    def second_part(self, input_string: str):

        return suma
