import copy


class Brick:
    def __init__(self, start, end, name):
        self.start_coord = start
        self.end_coord = end
        self.name = name

    def intersects(self, other_brick):
        # Check if the bricks intersect in any dimension (x, y, z)
        for i in range(3):
            if (
                    self.start_coord[i] <= other_brick.end_coord[i]
                    and self.end_coord[i] >= other_brick.start_coord[i]
            ):
                continue
            else:
                return False
        return True


class Puzzle:
    def first_part(self, input_string: str):
        rows = [a for a in input_string.split('\n')]
        bricks = []
        i = 0
        for row in rows:
            i += 1
            start, end = row.split('~')
            start = tuple(map(int, start.split(',')))
            end = tuple(map(int, end.split(',')))
            brick = Brick(start, end, i)
            bricks.append(brick)

        print('lowering...')
        lower_bricks(bricks)
        print('lowered')

        return len(find_bricks_to_remove(bricks))

    def second_part(self, input_string: str):
        rows = [a for a in input_string.split('\n')]
        bricks = []
        i = 0
        for row in rows:
            i += 1
            start, end = row.split('~')
            start = tuple(map(int, start.split(',')))
            end = tuple(map(int, end.split(',')))
            brick = Brick(start, end, i)
            bricks.append(brick)

        print('lowering...')
        lower_bricks(bricks)
        print('lowered')

        sum = 0
        count = 0
        for brick in bricks:
            count +=1
            print('checking', count, brick)
            new_bricks = copy.copy(bricks)
            new_bricks.remove(brick)
            count = len(lower_bricks(new_bricks))
            sum += count
            print('can lower', count)


        return sum

def can_move_down(brick, bricks):
    for other_brick in bricks:
        if brick != other_brick:
            lowered_brick = Brick(
                (
                    brick.start_coord[0],
                    brick.start_coord[1],
                    brick.start_coord[2] - 1,
                ),
                (
                    brick.end_coord[0],
                    brick.end_coord[1],
                    brick.end_coord[2] - 1,
                ),
                brick.name,
            )
            if lowered_brick.intersects(other_brick):
                return False
    return brick.start_coord[2] > 1

def lower_bricks(bricks):
    total_moved_bricks = {}
    while True:
        moved = False
        for i, current_brick in enumerate(bricks):
            if can_move_down(current_brick, bricks):
                current_brick.start_coord = (
                    current_brick.start_coord[0],
                    current_brick.start_coord[1],
                    current_brick.start_coord[2] - 1,
                )
                current_brick.end_coord = (
                    current_brick.end_coord[0],
                    current_brick.end_coord[1],
                    current_brick.end_coord[2] - 1,
                )
                total_moved_bricks[current_brick] = True
                moved = True
        if not moved:
            break

    return total_moved_bricks


def calculate_supporting_bricks(bricks):
    supporting_bricks = {brick: {} for brick in bricks}

    for brick in bricks:
        for other_brick in bricks:
            if brick is not other_brick:
                lowered_brick = Brick(
                    (
                        other_brick.start_coord[0],
                        other_brick.start_coord[1],
                        other_brick.start_coord[2] - 1,
                    ),
                    (
                        other_brick.end_coord[0],
                        other_brick.end_coord[1],
                        other_brick.end_coord[2] - 1,
                    ),
                    other_brick.name,
                )

                if lowered_brick.intersects(brick):
                    supporting_bricks[brick][other_brick] =other_brick

    return supporting_bricks

def find_bricks_to_remove(bricks):
    print('calculating supporting bricks...')
    supporting_bricks = calculate_supporting_bricks(bricks)
    print('finished', len(supporting_bricks))
    bricks_to_remove = set()

    for brick in bricks:
        supporting_count = len(supporting_bricks[brick])
        if supporting_count == 0:
            bricks_to_remove.add(brick)
            continue

        bricks_to_check_for_other_parent = {brick: False for brick in supporting_bricks[brick]}
        # check if there is other brick which supports
        for brick_to_check in bricks_to_check_for_other_parent:
            for supporting_brick in supporting_bricks:
                if supporting_brick == brick:
                    continue
                if brick_to_check in supporting_bricks[supporting_brick]:
                    bricks_to_check_for_other_parent[brick_to_check] = True

        if all(True == bricks_to_check_for_other_parent[brick] for brick in bricks_to_check_for_other_parent):
            bricks_to_remove.add(brick)

    return bricks_to_remove
