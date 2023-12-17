from functools import lru_cache

class Puzzle:
    def first_part(self, input_string: str):
        map = [[*a] for a in input_string.split('\n')]

        print('\n'.join(''.join(a) for a in map))

        running = True
        while running:
            running = False
            for row_key in range(len(map)):
                if row_key == 0:
                    continue
                for char_key in range(len(map[row_key])):
                    if map[row_key][char_key] != 'O':
                        continue
                    if map[row_key - 1][char_key] == '.':
                        map[row_key - 1][char_key] = 'O'
                        map[row_key][char_key] = '.'
                        running = True

        print('_' * 10 + '\n', '\n'.join(''.join(a) for a in map))

        suma = 0

        for i in range(len(map)):
            index = len(map) - i
            suma += map[i].count('O') * index

        return suma

    # 93736 CORRECT
    def second_part(self, input_string: str):
        grid = [[*a] for a in input_string.split('\n')]
        grid = tuple(map(tuple, grid))

        iterations = []
        i = 1
        ignore_cache = False
        while True:
            i += 1
            print(f"Progress: {i}/1000000000", i / 1000000000, end='\r')
            grid = rotate(grid)

            if not ignore_cache:
                if tuple(map(tuple, grid)) in iterations:
                    index = iterations.index(tuple(map(tuple, grid)))
                    difference = i - index
                    next_i = i
                    while True:
                        if (next_i + difference) < 1000000000:
                            next_i += difference
                        else:
                            break
                    print(
                        'index', index, '\n',
                        'i: ', i, '\n',
                        'next_i: ', next_i, '\n',
                        'difference: ', difference, '\n',
                    )
                    i = next_i - 2
                    print('moving to:', i)
                    ignore_cache = True
                    continue

            if not ignore_cache:
                iterations.append(tuple(map(tuple, grid)))

            if i >= 1000000000:
                break

        print('_' * 10 + '\n', '\n'.join(''.join(a) for a in grid))
        suma = 0

        for i in range(len(grid)):
            index = len(grid) - i
            suma += grid[i].count('O') * index

        return suma


@lru_cache()
def rotate(grid):
    grid = [list(inner_tuple) for inner_tuple in grid]
    grid = move_rocks(grid, 'N')
    grid = move_rocks(grid, 'W')
    grid = move_rocks(grid, 'S')
    grid = move_rocks(grid, 'E')

    grid = tuple(map(tuple, grid))

    return grid


def move_rocks(grid, direction):
    def rotate_right(grid):
        transposed_matrix = [list(row) for row in zip(*grid)]
        return [row[::-1] for row in transposed_matrix]

    def rotate_left(grid):
        reversed_rows = [row[::-1] for row in grid]
        return [list(row) for row in zip(*reversed_rows)]

    def inverse(grid):
        return grid[::-1]

    if direction == 'W':
        grid = rotate_right(grid)
    if direction == 'S':
        grid = inverse(grid)
    if direction == 'E':
        grid = rotate_left(grid)

    running = True
    while running:
        running = False
        for row_key in range(len(grid)):
            if row_key == 0:
                continue
            for char_key in range(len(grid[row_key])):
                if grid[row_key][char_key] != 'O':
                    continue
                if grid[row_key - 1][char_key] == '.':
                    grid[row_key - 1][char_key] = 'O'
                    grid[row_key][char_key] = '.'
                    running = True

    if direction == 'W':
        grid = rotate_left(grid)
    if direction == 'S':
        grid = inverse(grid)
    if direction == 'E':
        grid = rotate_right(grid)
    return grid
