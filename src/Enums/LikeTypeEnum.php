<?php

namespace JobMetric\Like\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

/**
 * @method static LIKE()
 * @method static DISLIKE()
 */
enum LikeTypeEnum : string {
    use EnumToArray;

    case LIKE = "like";
    case DISLIKE = "dislike";
}
