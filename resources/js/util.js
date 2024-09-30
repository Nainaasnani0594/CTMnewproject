export const to_roman_numerical = (number) => {
    const roman_numerals = {
        1: "I",
        2: "II",
        3: "III",
        4: "IV",
    };

    if (number < 1 || number > 4) {
        throw new Error("Number must be between 1 and 4");
    }

    return roman_numerals[number];
};

export const hasRole = (roles, user) => {
    if (!user || !user.roles || !Array.isArray(user.roles)) {
        return false;
    }
    const rolesToCheck = Array.isArray(roles) ? roles : [roles];
    return user.roles.some((userRole) =>
        rolesToCheck.includes(userRole.name)
    );
};
