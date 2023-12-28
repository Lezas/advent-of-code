from collections import deque


class Puzzle:
    def first_part(self, input_string: str):
        grid = [tuple([*row]) for row in input_string.split('\n')]
        center_position = ()
        for row_key, row in enumerate(grid):
            for column_key, char in enumerate(row):
                if char == 'S':
                    center_position = (row_key, column_key)

        print(center_position)

        paths = {
            center_position: center_position,
        }

        for i in range(64):
            print(i, len(paths), end='\r')
            new_paths = {}

            for path in paths:
                for dx, dy in [(1, 0), (-1, 0), (0, 1), (0, -1)]:
                    new_current = (path[0] + dx, path[1] + dy)

                    if new_current in new_paths:
                        continue

                    if new_current[0] < 0 or new_current[0] > len(grid):
                        continue

                    if new_current[1] < 0 or new_current[1] > len(grid[0]):
                        continue

                    if grid[new_current[0]][new_current[1]] == '#':
                        continue

                    new_paths[new_current] = new_current

            paths = new_paths

        print(i, len(paths))

        return len(paths)

    def second_part(self, input_string: str):
        grid = [tuple([*row]) for row in input_string.split('\n')]
        center_position = ()
        for row_key, row in enumerate(grid):
            for column_key, char in enumerate(row):
                if char == 'S':
                    center_position = (row_key, column_key)

        visited = {}

        d = deque()
        d.append((0, center_position))
        while d:
            distance, coord = d.popleft()
            if coord in visited:
                continue

            visited[coord] = distance

            for dx, dy in [(1, 0), (-1, 0), (0, 1), (0, -1)]:
                next_coord = (coord[0] + dx, coord[1] + dy)
                if next_coord[0] < 0 or next_coord[0] > len(grid) - 1:
                    continue

                if next_coord[1] < 0 or next_coord[1] > len(grid[0]) - 1:
                    continue

                if grid[next_coord[0]][next_coord[1]] == '#':
                    continue

                if next_coord in visited:
                    continue
                d.append((distance + 1, next_coord))

        # part one alternative solution
        filtered_dict = len({key: value for key, value in visited.items() if value <= 64 and value % 2 == 0})

        even_corners = len({key: value for key, value in visited.items() if value > 65 and value % 2 == 0})
        odd_corners = len({key: value for key, value in visited.items() if value > 65 and value % 2 == 1})

        n = int(round(((26501365 - (len(grid) / 2)) / len(grid))))

        even = n * n
        odd = (n + 1) * (n + 1)

        visited_odd = len({key: value for key, value in visited.items() if value % 2 == 1})
        visited_even = len({key: value for key, value in visited.items() if value % 2 == 0})

        result = odd * visited_odd + even * visited_even - ((n + 1) * odd_corners) + (n * even_corners)

        return result
