import math


class Puzzle:
    def first_part(self, input_string):
        print(input_string.split('\n'))
        passes = [[*a] for a in input_string.split('\n')]

        highest_seat_id = 0
        for pas in passes:
            highest_seat = 0
            mi = 0
            ma = 127

            for operation in pas[0:7]:
                if operation == 'F':
                    ma = math.floor(ma - (ma - mi) / 2)
                elif operation == 'B':
                    mi = mi + math.ceil((ma - mi) / 2)
            highest_row = ma
            mi = 0
            ma = 7

            for operation in pas[7:10]:
                if operation == 'L':
                    ma = math.floor(ma - (ma - mi) / 2)
                elif operation == 'R':
                    mi = mi + math.ceil((ma - mi) / 2)
            highest_seat = ma


            id = highest_row * 8 + highest_seat

            # print(pas, highest_row, highest_seat, id)
            if id > highest_seat_id:
                highest_seat_id = id

        return highest_seat_id


    def second_part(self, input_string):
        passes = [[*a] for a in input_string.split('\n')]

        seat_ids = []
        highest_seat_id = 0
        for pas in passes:
            highest_seat = 0
            mi = 0
            ma = 127

            for operation in pas[0:7]:
                if operation == 'F':
                    ma = math.floor(ma - (ma - mi) / 2)
                elif operation == 'B':
                    mi = mi + math.ceil((ma - mi) / 2)
            highest_row = ma
            mi = 0
            ma = 7

            for operation in pas[7:10]:
                if operation == 'L':
                    ma = math.floor(ma - (ma - mi) / 2)
                elif operation == 'R':
                    mi = mi + math.ceil((ma - mi) / 2)
            highest_seat = ma

            id = highest_row * 8 + highest_seat
            seat_ids.append(id)

            # print(pas, highest_row, highest_seat, id)
            if id > highest_seat_id:
                highest_seat_id = id

        seat_ids.sort()
        ma = seat_ids[0]

        print(seat_ids)
        last = ma - 1
        for id in seat_ids:
            if id != last +1:
                return id -1
            last = id
        return highest_seat_id
