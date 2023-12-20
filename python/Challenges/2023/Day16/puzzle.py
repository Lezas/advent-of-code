class Puzzle:
    def first_part(self, input_string: str):
        map = [[*a] for a in input_string.split('\n')]
        path = {
            'current_location': [0, -1],
            'direction': 'R',
            'visited': {},
        }

        return calculate_energized_cells(map, path)

    def second_part(self, input_string: str):
        map = [[*a] for a in input_string.split('\n')]
        max_count = 0
        for i in range(len(map)):
            path = {
                'current_location': [i, -1],
                'direction': 'R',
                'visited': {},
            }
            count = calculate_energized_cells(map, path)
            if count > max_count:
                max_count = count
            path = {
                'current_location': [i, len(map[0])],
                'direction': 'L',
                'visited': {},
            }
            count = calculate_energized_cells(map, path)
            if count > max_count:
                max_count = count
        for i in range(len(map[0])):
            path = {
                'current_location': [-1, i],
                'direction': 'D',
                'visited': {},
            }
            count = calculate_energized_cells(map, path)
            if count > max_count:
                max_count = count
            path = {
                'current_location': [len(map), i],
                'direction': 'U',
                'visited': {},
            }
            count = calculate_energized_cells(map, path)
            if count > max_count:
                max_count = count
        return max_count


def calculate_energized_cells(map, path):
    paths = [path]

    directions = {
        'U': [-1, 0],
        'R': [0, 1],
        'D': [1, 0],
        'L': [0, -1],
    }
    total_visited = {}

    for path in paths:
        while True:
            direction = path['direction']
            next_location = [
                path['current_location'][0] + directions[direction][0],
                path['current_location'][1] + directions[direction][1],
            ]

            if (next_location[0] >= len(map) or next_location[0] < 0) or (
                    next_location[1] >= len(map[1]) or next_location[1] < 0):
                # reached out of bounds
                break

            visited_cell = (next_location[0], next_location[1])
            if visited_cell in path['visited'] and path['visited'][visited_cell][direction]:
                # repeating
                break
            if visited_cell not in path['visited']:
                path['visited'][visited_cell] = {
                    'R': False,
                    'D': False,
                    'L': False,
                    'U': False,
                }
            path['visited'][visited_cell][direction] = True

            total_visited[visited_cell] = True

            next_character = map[next_location[0]][next_location[1]]

            path['current_location'] = next_location

            if next_character == '|':
                if direction in ['L', 'R']:
                    # split up the path
                    path['direction'] = 'U'

                    new_path = path.copy()
                    new_path['direction'] = 'D'
                    paths.append(new_path)
            if next_character == '-':
                if direction in ['U', 'D']:
                    path['direction'] = 'R'

                    new_path = path.copy()
                    new_path['direction'] = 'L'
                    paths.append(new_path)
            if next_character == '?':
                path['direction'] = {
                    'D': 'R',
                    'U': 'L',
                    'R': 'D',
                    'L': 'U',
                }[direction]
            if next_character == '/':
                path['direction'] = {
                    'D': 'L',
                    'U': 'R',
                    'R': 'U',
                    'L': 'D',
                }[direction]

    return len(total_visited)