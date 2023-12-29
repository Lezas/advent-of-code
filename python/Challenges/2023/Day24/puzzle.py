class Puzzle:
    def first_part(self, input_string: str):
        values = [a.split(' @ ') for a in input_string.split('\n')]
        hails = []
        for current_pos, velocity in values:
            position = tuple(map(int, current_pos.split(', ')))
            velocity = tuple(map(int, velocity.split(', ')))
            hails.append({'position': position, 'velocity': velocity})

        count = 0
        boundary = (200000000000000, 400000000000000)
        for i in range(len(hails)):
            for j in range(i + 1, len(hails)):
                intersection_point = find_intersection_point(hails[i]['position'][0], hails[i]['position'][1],
                                                             hails[i]['velocity'][0], hails[i]['velocity'][1],
                                                             hails[j]['position'][0], hails[j]['position'][1],
                                                             hails[j]['velocity'][0], hails[j]['velocity'][1])
                if intersection_point is None:
                    continue
                if boundary[0] <= intersection_point[0] <= boundary[1] and boundary[0] <= intersection_point[1] <= \
                        boundary[1]:
                    count += 1

        return count

    def second_part(self, input_string: str):

        return 0


def find_intersection_point(x1, y1, vx1, vy1, x2, y2, vx2, vy2):
    k1 = ((y1 + vy1) - y1) / ((x1 + vx1) - x1)
    k2 = ((y2 + vy2) - y2) / ((x2 + vx2) - x2)
    if k1 == k2:
        return None

    b1 = y1 - k1 * x1
    b2 = y2 - k2 * x2

    intersection_x = (b1 - b2) / (k2 - k1)
    intersection_y = k1 * intersection_x + b1

    if vx1 < 0 and intersection_x > x1:
        return None

    if vx2 < 0 and intersection_x > x2:
        return None

    if vy1 < 0 and intersection_y > y1:
        return None

    if vy2 < 0 and intersection_y > y2:
        return None

    if vx1 > 0 and intersection_x < x1:
        return None

    if vx2 > 0 and intersection_x < x2:
        return None

    if vy1 > 0 and intersection_y < y1:
        return None

    if vy2 > 0 and intersection_y < y2:
        return None

    return intersection_x, intersection_y
