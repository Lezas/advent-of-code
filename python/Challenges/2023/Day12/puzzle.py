import re
from functools import lru_cache


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
        # print(read_input(input_string))
        # exit()
        springs = []
        for value in [a.split(' ') for a in input_string.split('\n')]:
            springs.append(
                {
                    'conditions': '?'.join([value[0] for _ in range(5)]),
                    'springs_count':  tuple(map(int,(','.join([value[1] for _ in range(5)])).split(','))),
                    # 'springs_count': [int(value) for value in value[1].split(',')] * 5,
                    'springs_count_string': ','.join([value[1] for _ in range(5)]),
                }
            )

        suma = 0
        for configuration in springs:
            counter = count_combinations(configuration['conditions'], configuration['springs_count'])
            suma += counter

        return suma


@lru_cache()
def count_combinations(record, damages):
    def more_damaged_springs(): return len(damages) > 1

    def found_damaged_springs():
        return re.findall(r'^[\#\?]{%i}' % next_grp, record)

    def valid_next_spring(): return not(
        (len(record) < next_grp + 1) or record[next_grp] == '#')

    if not damages:
        return 0 if '#' in record else 1

    if not record:
        return 0

    result = 0
    next_ch = record[0]
    next_grp = damages[0]

    if next_ch == '#':
        if found_damaged_springs():
            if more_damaged_springs():
                if valid_next_spring():
                    result += count_combinations(record[next_grp + 1:], damages[1:])
                else:
                    return 0
            else:
                result += count_combinations(record[next_grp:], damages[1:])

    elif next_ch == '.':
        result += count_combinations(record[1:], damages)

    elif next_ch == '?':
        result += count_combinations(record.replace('?', '#', 1), damages) + \
                  count_combinations(record.replace('?', '.', 1), damages)

    return result
