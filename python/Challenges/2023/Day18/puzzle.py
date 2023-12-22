import re


def shoelace_formula(points):
    area = 0
    n = len(points)
    for i in range(n):
        x1, y1 = points[i]
        x2, y2 = points[(i + 1) % n]
        area += (x1 * y2 - x2 * y1)

    area = abs(area) / 2
    return area

class Puzzle:
    def first_part(self, input_string: str):
        pattern = re.compile(r'(?P<direction>\w)\s(?P<count>[\d\s]+)\s(?P<color>[\(\#\)\d\w]+)')
        lines = [pattern.match(a).groupdict() for a in input_string.split('\n')]
        current_position = (0, 0)
        directions = {'R': (0, 1), 'D': (1, 0), 'L': (0, -1), 'U': (-1, 0), }

        visited = [(0, 0)]

        for line in lines:
            direction, count = line['direction'], int(line['count'])
            dx, dy = directions[direction]
            current_position = (current_position[0] + dx * count, current_position[1] + dy * count)
            visited.append(current_position)

        return int(shoelace_formula(visited) + sum(int(line['count']) for line in lines) / 2 + 1)

    def second_part(self, input_string: str):
        pattern = re.compile(r'(?P<direction>\w)\s(?P<count>[\d\s]+)\s(?P<color>[\(\#\)\d\w]+)')
        lines = [pattern.match(a).groupdict() for a in input_string.split('\n')]
        current_position = (0, 0)
        directions = {'R': (0, 1), 'D': (1, 0), 'L': (0, -1), 'U': (-1, 0), }

        visited = [(0, 0)]

        suma = 0
        for line in lines:
            color = line['color']
            count = int(color[2:7], 16)
            direction = {
                0: 'R',
                1: 'D',
                2: 'L',
                3: 'U',
            }[int(color[-2])]
            suma += count
            dx, dy = directions[direction]
            current_position = (current_position[0] + dx * count, current_position[1] + dy * count)
            visited.append(current_position)

        return int(shoelace_formula(visited) + suma / 2 + 1)
