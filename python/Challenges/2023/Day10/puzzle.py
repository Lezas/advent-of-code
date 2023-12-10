from matplotlib.path import Path


class BreakLoop(Exception):
    pass


class Puzzle:
    def first_part(self, input_string: str):
        grid = [[*row] for row in input_string.split('\n')]
        s_row = -1
        s_column = -1
        try:
            for row_key, row in enumerate(grid):
                for char_key, char in enumerate(row):
                    if char == 'S':
                        s_row = row_key
                        s_column = char_key

                        raise BreakLoop
        except BreakLoop:
            pass

        allowed_pipes = {
            'north': ['7', 'F', '|'],
            'south': ['L', 'J', '|'],
            'east': ['J', '7', '-'],
            'west': ['L', 'F', '-'],
        }

        allowed = {
            '|': ['south', 'north'],
            '-': ['west', 'east'],
            'L': ['north', 'east'],
            'J': ['north', 'west'],
            'F': ['south', 'east'],
            '7': ['south', 'west'],
            'S': ['north', 'west', 'east', 'south'],
        }

        current_pos = {
            'row': s_row,
            'column': s_column,
        }

        previuos_pos = {
            'row': s_row,
            'column': s_column,
        }

        neighbourds_check = {
            'north': [-1, 0],
            'south': [1, 0],
            'east': [0, 1],
            'west': [0, -1],
        }

        steps = 0
        while True:
            current_char = grid[current_pos['row']][current_pos['column']]
            allowed_directions = allowed[current_char]

            for allowed_direction in allowed_directions:
                check = neighbourds_check[allowed_direction]
                neighbour = [
                    current_pos['row'] + check[0],
                    current_pos['column'] + check[1],
                ]

                if neighbour[0] < 0 or neighbour[0] > (len(grid) - 1):
                    continue
                elif neighbour[1] < 0 or neighbour[1] > (len(grid[neighbour[0]]) - 1):
                    continue
                if neighbour[0] == previuos_pos['row'] and neighbour[1] == previuos_pos['column']:
                    continue

                next_position_char = grid[neighbour[0]][neighbour[1]]

                pipes_to_check = allowed_pipes[allowed_direction]

                if next_position_char == 'S':
                    steps += 1
                    return int(steps / 2)

                if next_position_char in pipes_to_check:
                    previuos_pos['row'] = current_pos['row']
                    previuos_pos['column'] = current_pos['column']
                    current_pos['row'] = neighbour[0]
                    current_pos['column'] = neighbour[1]
                    steps += 1
                    break

        return 1

    def second_part(self, input_string: str):
        grid = [[*row] for row in input_string.split('\n')]
        s_row = -1
        s_column = -1
        try:
            for row_key, row in enumerate(grid):
                for char_key, char in enumerate(row):
                    if char == 'S':
                        s_row = row_key
                        s_column = char_key

                        raise BreakLoop
        except BreakLoop:
            pass

        allowed_pipes = {
            'north': ['7', 'F', '|'],
            'south': ['L', 'J', '|'],
            'east': ['J', '7', '-'],
            'west': ['L', 'F', '-'],
        }

        allowed = {
            '|': ['south', 'north'],
            '-': ['west', 'east'],
            'L': ['north', 'east'],
            'J': ['north', 'west'],
            'F': ['south', 'east'],
            '7': ['south', 'west'],
            'S': ['north', 'west', 'east', 'south'],
        }

        current_pos = {
            'row': s_row,
            'column': s_column,
        }

        previuos_pos = {
            'row': s_row,
            'column': s_column,
        }

        neighbourds_check = {
            'north': [-1, 0],
            'south': [1, 0],
            'east': [0, 1],
            'west': [0, -1],
        }

        mapas = [[0] * len(grid[0]) for _ in range(len(grid))]

        poly = [(s_row, s_column)]

        mapas[s_row][s_column] = 1
        steps = 0
        found = False
        while not found:
            current_char = grid[current_pos['row']][current_pos['column']]
            allowed_directions = allowed[current_char]

            for allowed_direction in allowed_directions:
                check = neighbourds_check[allowed_direction]
                neighbour = [
                    current_pos['row'] + check[0],
                    current_pos['column'] + check[1],
                ]

                if neighbour[0] < 0 or neighbour[0] > (len(grid) - 1):
                    continue
                elif neighbour[1] < 0 or neighbour[1] > (len(grid[neighbour[0]]) - 1):
                    continue
                if neighbour[0] == previuos_pos['row'] and neighbour[1] == previuos_pos['column']:
                    continue

                next_position_char = grid[neighbour[0]][neighbour[1]]

                pipes_to_check = allowed_pipes[allowed_direction]

                if next_position_char == 'S':
                    steps += 1
                    found = True
                    break

                if next_position_char in pipes_to_check:
                    previuos_pos['row'] = current_pos['row']
                    previuos_pos['column'] = current_pos['column']
                    current_pos['row'] = neighbour[0]
                    current_pos['column'] = neighbour[1]
                    steps += 1
                    mapas[current_pos['row']][current_pos['column']] = grid[current_pos['row']][current_pos['column']]
                    poly.append([current_pos['row'], current_pos['column']])
                    break

        p = Path(poly)
        answer = 0
        for y in range(len(grid)):
            for x in range(len(grid[0])):
                if [x, y] in poly:
                    continue
                if p.contains_point((x, y)):
                    answer += 1
        # returns +1 in the answer...
        return answer
