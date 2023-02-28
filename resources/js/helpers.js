export const formatPrice = (number) => {
    return number.toLocaleString('en-PH', {
        style: 'currency',
        currency: 'PHP',
    });
}