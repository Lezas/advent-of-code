from itertools import combinations
import math
import re


class Puzzle:
    def first_part(self, input_string: str):
        springs = []
        for value in [a.split(' ') for a in input_string.split('\n')]:
            springs.append(
                {
                    'conditions': value[0],
                    'springs_count': value[1].split(','),
                    'springs_count_string': value[1],
                }
            )

        suma = 0
        for configuration in springs:
            combinations = self.generate_possible_combinations(configuration['conditions'])
            possible = []
            for combination in combinations:
                counts = self.get_springs_count(combination)
                if configuration['springs_count_string'] == ','.join(map(str, counts)):
                    possible.append(combination)

            suma += len(possible)
            print(configuration['conditions'], configuration['springs_count_string'], possible)

        return suma
    def get_springs_count(self, springs_string):
        groups = springs_string.split('.')
        counts = []
        for group in groups:
            counts.append(group.count('#'))

        return list(filter(lambda x: x != 0, counts))

    def generate_possible_combinations(self, conditions):
        if '?' not in conditions:
            return [conditions]

        positions = [index for index, char in enumerate(conditions) if char == '?']
        possible_conditions = [conditions]

        for position in positions:
            possible_conditions = [new_condition[:position] + possible_char + new_condition[position + 1:] for
                                   new_condition in
                                   possible_conditions for possible_char in ['#', '.']]

        return possible_conditions

    def second_part(self, input_string: str):

        return suma
