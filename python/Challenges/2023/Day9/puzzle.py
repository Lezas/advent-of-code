class Puzzle:
    def first_part(self, input_string: str):
        rows = [list(map(int, row.split())) for row in input_string.split('\n')]

        return sum(self.get_prediction_of_last_value(row) for row in rows)

    def get_prediction_of_last_value(self, row):
        iterations = 0

        last_numbers = []
        while True:
            iterations += 1
            last_number = 0
            new_row = []
            for i in (range(len(row) - 1)):
                num1 = row[i]
                last_number = num2 = row[i + 1]
                avg = num2 - num1
                new_row.append(avg)

            last_numbers.append(last_number)
            row = new_row

            if all(value == 0 for value in new_row):
                break

        last_numbers.reverse()

        current = 0
        for i in range(iterations):
            last_number = last_numbers[i]
            current += last_number
        return current

    def second_part(self, input_string: str):
        rows = [list(map(int, row.split())) for row in input_string.split('\n')]

        return sum(self.get_prediction_of_first_value(row) for row in rows)

    def get_prediction_of_first_value(self, row):
        iterations = 0

        last_numbers = []
        while True:
            iterations += 1
            first_number = row[0]
            new_row = []

            for i in (range(len(row) - 1)):
                num1 = row[i]
                num2 = row[i + 1]
                avg = num2 - num1
                new_row.append(avg)

            last_numbers.append(first_number)
            row = new_row

            if all(value == 0 for value in new_row):
                break

        last_numbers.reverse()

        current = 0
        for i in range(iterations):
            last_number = last_numbers[i]
            current = last_number - current
        return current