class Puzzle:
    def first_part(self, input_string: str):
        rows = [row for row in input_string.split('\n')]
        result_map = []
        for row in rows:
            length = len(row)
            if any(row.count(char) == length for char in set(row)):
                result_map.append(row)
            result_map.append(row)

        for row in result_map:
            print(row)
        rows = result_map
        result_map = []

        for row in rows:
            result_map.append([])

        for column_key in range(len(rows[0])):
            result_list = [''.join(row[column_key]) for row in rows]
            column_chars = ''.join(result_list)
            all_equal = any(column_chars.count(char) == len(column_chars) for char in set(column_chars))

            for row_key, row in enumerate(rows):
                column_value = row[column_key]
                result_map[row_key].append(column_value)
                if all_equal:
                    result_map[row_key].append(column_value)

        for row in result_map:
            print(''.join(row))

        galaxies = []

        for row_key, row in enumerate(result_map):
            for column_key, column in enumerate(row):
                if column == '#':
                    galaxies.append([row_key, column_key])
        print(galaxies)
        all_pairs = [(coord1, coord2) for i, coord1 in enumerate(galaxies) for coord2 in galaxies[i + 1:]]
        print(all_pairs)
        print(len(all_pairs))
        suma = 0
        for pair in all_pairs:
            coord1 = pair[0]
            coord2 = pair[1]
            length = abs(coord2[1] - coord1[1]) + abs(coord2[0] - coord1[0])
            if length < 0:
                length *= -1

            suma += length
            print(coord1, coord2, length, suma)

        return suma

    # 6876732 wrong
    def second_part(self, input_string: str):
        rows = [row for row in input_string.split('\n')]
        result_map = []
        empty_rows = []
        empty_columns = []
        for row_key, row in enumerate(rows):
            length = len(row)
            if any(row.count(char) == length for char in set(row)):
                empty_rows.append(row_key)
            result_map.append(row)

        rows = result_map
        result_map = []

        for row in rows:
            result_map.append([])

        for column_key in range(len(rows[0])):
            result_list = [''.join(row[column_key]) for row in rows]
            column_chars = ''.join(result_list)
            all_equal = any(column_chars.count(char) == len(column_chars) for char in set(column_chars))
            if all_equal:
                empty_columns.append(column_key)

            for row_key, row in enumerate(rows):
                column_value = row[column_key]
                result_map[row_key].append(column_value)

        galaxies = []

        for row_key, row in enumerate(result_map):
            for column_key, column in enumerate(row):
                if column == '#':
                    galaxies.append([row_key, column_key])
        all_pairs = [(coord1, coord2) for i, coord1 in enumerate(galaxies) for coord2 in galaxies[i + 1:]]
        suma = 0

        expansion_rate = 1000000
        for pair in all_pairs:
            coord1 = pair[0]
            coord2 = pair[1]
            length = abs(coord2[1] - coord1[1]) + abs(coord2[0] - coord1[0])

            for empty_row in empty_rows:
                if (empty_row > coord1[0] and empty_row < coord2[0]):
                    length += expansion_rate - 1

            for empty_column in empty_columns:
                if (empty_column > coord1[1] and empty_column < coord2[1]):
                    length += expansion_rate - 1
                if (empty_column > coord2[1] and empty_column < coord1[1]):
                    length += expansion_rate - 1

            suma += length

        return suma
