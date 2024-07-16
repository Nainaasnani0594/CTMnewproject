export const to_roman_numerical = (number) => {
    const roman_numerals = {
        M: 1000,
        CM: 900,
        D: 500,
        CD: 400,
        C: 100,
        XC: 90,
        L: 50,
        XL: 40,
        X: 10,
        IX: 9,
        V: 5,
        IV: 4,
        I: 1,
    };

    let result = "";

    for (const key in roman_numerals) {
        const value = roman_numerals[key];
        result += key.repeat(Math.floor(number / value));
        number %= value;
    }

    return result;
};
