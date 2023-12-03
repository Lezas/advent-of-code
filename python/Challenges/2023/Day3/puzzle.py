class Puzzle:
    def first_part(self, input_string: str):
        suma = 0
        rows = [[*a] for a in input_string.split('\n')]
        for row_number in range(len(rows)):
            row = rows[row_number]
            number_string = ''
            neighbour_has_symbol = False
            for column_number in range(len(row)):
                char = row[column_number]
                if char.isdigit():
                    number_string += char
                    if neighbour_has_symbol == False:
                        neighbour_has_symbol = self.neighbour_has_symbol_first_part(rows, row_number, column_number)
                else:
                    if neighbour_has_symbol == True:
                        suma += int(number_string)
                    neighbour_has_symbol = False
                    number_string = ''
                    continue
            if number_string.isdigit() and neighbour_has_symbol == True:
                suma += int(number_string)

        return suma

    def neighbour_has_symbol_first_part(self, grid, curr_row, curr_column):
        neighbours_coordinates = [
            [-1, 1],
            [-1, 0],
            [-1, -1],
            [1, 1],
            [1, 0],
            [1, -1],
            [0, 1],
            [0, -1],
            [0, 0],
        ]

        asserted_chars = ''
        for neighbour_coordinates in neighbours_coordinates:
            assert_row_no = curr_row + neighbour_coordinates[0]
            assert_column_no = curr_column + neighbour_coordinates[1]
            if (assert_row_no < 0
                    or assert_column_no < 0
                    or assert_row_no > len(grid) -1
                    or assert_column_no > len(grid[assert_row_no]) - 1
            ):
                continue
            assert_char = grid[assert_row_no][assert_column_no]

            asserted_chars += assert_char
            if assert_char == '.' or assert_char.isdigit():
                continue
            else:
                return True

        return False

    def second_part(self, input_string: str):
        rows = [[*a] for a in input_string.split('\n')]

        gears = {}

        for row_number in range(len(rows)):
            row = rows[row_number]
            number_string = ''
            neighbour_has_symbol = False
            for column_number in range(len(row)):
                char = row[column_number]
                if char.isdigit():
                    number_string += char
                    if neighbour_has_symbol == False:
                        neighbour_has_symbol, symbol, symbol_row_no, symbol_column_no = self.neighbour_has_symbol_second_part(rows, row_number, column_number)
                        if neighbour_has_symbol and symbol == '*':
                            key = str(symbol_row_no) + ':' + str(symbol_column_no)
                            if not key in gears:
                                gears[key] = {
                                    'row_no' : symbol_row_no,
                                    'column_no' : symbol_column_no,
                                    'numbers' : []
                                }
                else:
                    if neighbour_has_symbol == True and symbol == '*':
                        key = str(symbol_row_no) + ':' + str(symbol_column_no)
                        gears[key]['numbers'].append(int(number_string))
                    neighbour_has_symbol = False
                    number_string = ''

            if number_string.isdigit() and neighbour_has_symbol == True and symbol == '*':
                key = str(symbol_row_no) + ':' + str(symbol_column_no)
                gears[key]['numbers'].append(int(number_string))

        suma = 0
        for gear_id in gears:
            gear = gears[gear_id]
            if len(gear['numbers']) > 1:
                ratio = Puzzle.multiplyList(gear['numbers'])
                suma += ratio

        return suma

    def neighbour_has_symbol_second_part(self, grid, curr_row, curr_column):
        neighbours_coordinates = [
            [-1, 1],
            [-1, 0],
            [-1, -1],
            [1, 1],
            [1, 0],
            [1, -1],
            [0, 1],
            [0, -1],
            [0, 0],
        ]

        asserted_chars = ''
        for neighbour_coordinates in neighbours_coordinates:
            assert_row_no = curr_row + neighbour_coordinates[0]
            assert_column_no = curr_column + neighbour_coordinates[1]
            if (assert_row_no < 0
                    or assert_column_no < 0
                    or assert_row_no > len(grid) -1
                    or assert_column_no > len(grid[assert_row_no]) - 1
            ):
                continue
            assert_char = grid[assert_row_no][assert_column_no]

            asserted_chars += assert_char
            if assert_char == '.' or assert_char.isdigit():
                continue
            else:
                return True, assert_char, assert_row_no, assert_column_no

        return False, False, False, False


    def multiplyList(myList):
        # Multiply elements one by one
        result = 1
        for x in myList:
            result = result * x
        return result