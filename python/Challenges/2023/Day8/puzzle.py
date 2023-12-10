import re
import math


class Puzzle:
    def first_part(self, input_string: str):
        split = input_string.split('\n\n')
        directions = split[0]

        pattern = r'(?P<current_position>\w+)\s=\s\((?P<left>\w+),\s(?P<right>\w+)\)'

        rows = [re.match(pattern, a).groupdict() for a in split[1].split('\n')]
        map = {}
        for row in rows:
            map[row['current_position']] = row
        directions_length = len(directions)

        steps_count = 0
        current_position = 'AAA'
        current_direction_position = 0
        while 1:
            steps_count += 1
            current_node = map[current_position]
            current_direction = directions[current_direction_position]
            current_direction_position += 1
            if current_direction_position > directions_length - 1:
                current_direction_position = 0

            next_node = current_node['left'] if current_direction == 'L' else current_node['right']
            current_position = next_node
            if next_node == 'ZZZ':
                return steps_count

        return 0

    def get_steps_count(self, current_node, map, directions):
        directions_length = len(directions)
        steps_count = 0
        current_direction_position = 0
        while 1:
            steps_count += 1
            current_direction = directions[current_direction_position]
            current_direction_position += 1
            if current_direction_position > directions_length - 1:
                current_direction_position = 0

            current_node = map[current_node['left'] if current_direction == 'L' else current_node['right']]

            if current_node['position'][2] == 'Z':
                return steps_count

        return 0

    def second_part(self, input_string: str):
        directions, rows_part = input_string.split('\n\n')

        pattern = r'(?P<position>\w+)\s=\s\((?P<left>\w+),\s(?P<right>\w+)\)'

        rows = [re.match(pattern, a).groupdict() for a in rows_part.split('\n')]
        nodes_map = {row['position']: row for row in rows}

        counters = [self.get_steps_count(current_node, nodes_map, directions) for current_node in [
            {
                'position': position,
                'left': node['left'],
                'right': node['right'],
            }
            for position, node in nodes_map.items() if position[2] == 'A'
        ]]

        return math.lcm(*counters)
