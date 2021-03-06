<?php

declare(strict_types=1);

namespace Grandmaster\Evaluator;

use Grandmaster\Chessboard;
use Grandmaster\Evaluator;
use Grandmaster\Pieces\PointValue;

final class MaterialEvaluator implements Evaluator
{
    public function evaluate(Chessboard $board): int
    {
        // array_reduce is cleaner, but performance is the key here
        $sum = 0;
        foreach ($board->board() as $piece) {
            $sum += $this->getPieceValue($piece);
        }

        return $sum;
    }

    private function getPieceValue(?array $piece): int
    {
        if ($piece === null) {
            return 0;
        }
        $color = $piece['color'] === 'w' ? 1 : -1;

        switch ($piece['type']) {
            case 'p':
                return PointValue::PAWN * $color;
            case 'r':
                return PointValue::ROOK * $color;
            case 'n':
                return PointValue::KNIGHT * $color;
            case 'b':
                return PointValue::BISHOP * $color;
            case 'q':
                return PointValue::QUEEN * $color;
            case 'k':
                return PointValue::KING * $color;
            default:
                return 0;
        }
    }
}
