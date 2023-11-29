class Puzzle:
    def first_part(input_string: str):
        grid = [[*a] for a in input_string.split('\n')]
        return Puzzle.calculate(grid, 1, 3)

    def second_part(input_string: str):
        grid = [[*a] for a in input_string.split('\n')]

        params = [
            [1, 1],
            [1, 3],
            [1, 5],
            [1, 7],
            [2, 1],
        ]
        mult = 1
        for instr in params:
            mult *= Puzzle.calculate(grid, instr[0], instr[1])

        return mult

    def calculate(grid, move_height, move_width):
        height = len(grid) - 1
        width = len(grid[0]) - 1

        current_height = move_height
        current_width = move_width

        trees_count = 0
        while current_height <= height:
            symbol = grid[current_height][current_width]
            if symbol == '#':
                trees_count = trees_count + 1

            current_height = current_height + move_height
            current_width = current_width + move_width
            if current_width >= width:
                current_width = current_width - width - 1

        return trees_count
