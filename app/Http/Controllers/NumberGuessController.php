<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NumberGuessController extends Controller
{
    /**
     * The secret number derived from the golden ratio (φ⁻¹ × 100 000 ≈ 61 803).
     *
     * Reasoning:
     *  - Mathematics: φ⁻¹ = (√5 − 1) / 2 ≈ 0.61803, giving 61 803 out of 100 000.
     *  - Psychology:  people avoid round numbers and extremes; the upper-middle
     *                 range feels "random" yet deliberate – a classic Schelling focal point.
     *  - Game theory: if both parties reason the same way, 61 803 is the
     *                 most likely convergence point.
     */
    private const SECRET_NUMBER = 61803;
    private const MIN = 1;
    private const MAX = 100000;

    public function index()
    {
        return view('numbergame.index', [
            'min' => self::MIN,
            'max' => self::MAX,
        ]);
    }

    public function guess(Request $request)
    {
        $validated = $request->validate([
            'number' => ['required', 'integer', 'min:' . self::MIN, 'max:' . self::MAX],
        ]);

        $guess  = (int) $validated['number'];
        $secret = self::SECRET_NUMBER;
        $won    = ($guess === $secret);

        return view('numbergame.index', [
            'min'    => self::MIN,
            'max'    => self::MAX,
            'guess'  => $guess,
            'secret' => $secret,
            'won'    => $won,
        ]);
    }
}
