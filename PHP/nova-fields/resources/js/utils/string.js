export function limit_words($value, amount, $ending = '...') {
    const words = $value.split(' ');

    if (amount >= words.length) {
        return $value;
    }

    const truncated = words.slice(0, amount);
    return `${truncated.join(' ')}${$ending}`;
}