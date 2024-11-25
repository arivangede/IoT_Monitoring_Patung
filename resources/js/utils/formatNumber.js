export default function formatNumber(value, decimals = 1) {
    if (isNaN(value)) return "-"; // Menangani nilai tidak valid
    return parseFloat(value).toFixed(decimals);
}
