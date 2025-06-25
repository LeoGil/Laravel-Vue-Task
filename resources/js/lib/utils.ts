import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function getBadgeStyle(hexColor: string): Record<string, string> {
    const { r, g, b } = hexToRgb(hexColor);

    const dark = isDarkMode();
    const bgAlpha = dark ? 0.18 : 1;
    const borderAlpha = dark ? 0.3 : 1;

    const backgroundColor = `rgba(${r}, ${g}, ${b}, ${bgAlpha})`;
    const border = `1px solid rgba(${r}, ${g}, ${b}, ${borderAlpha})`;

    const lum = (r * 299 + g * 587 + b * 114) / 1000;
    const isBgDark = lum < 158;

    let textColor = null
    if (dark) {
        textColor = isBgDark
        ? adjustHexContrast({ r, g, b }, 0.5, 'lighten')
        : adjustHexContrast({ r, g, b }, 0.2, 'darken');
    } else {
        textColor = isBgDark ? '#ffffff' : '#000000';
    }
    

    return {
        backgroundColor,
        border,
        color: textColor,
    };
}

function isDarkMode(): boolean {
    if (typeof window === 'undefined') return false;
    return document.documentElement.classList.contains('dark');
}

// passa HEX e retorna objeto RGB
function hexToRgb(hex: string): { r: number; g: number; b: number } {
    let clean = hex.replace('#', '');
    if (clean.length === 3) clean = clean.split('').map(c => c + c).join('');
    if (!/^[0-9A-Fa-f]{6}$/.test(clean)) {
        console.warn(`Invalid HEX color: ${hex}`);
        return { r: 0, g: 0, b: 0 };
    }
    return {
        r: parseInt(clean.slice(0, 2), 16),
        g: parseInt(clean.slice(2, 4), 16),
        b: parseInt(clean.slice(4, 6), 16),
    };
}

/**
 * Ajusta a cor HEX clareando ou escurecendo em `amount` (0–1).
 * - lighten: r += (255-r)*amount
 * - darken:  r *= (1-amount)
 */
function adjustHexContrast(
    rgb: {r:number,g:number,b:number},
    amount: number,
    mode: 'lighten' | 'darken'
): string {
    const { r, g, b } = rgb;
    const clamp = (v: number) => Math.max(0, Math.min(255, Math.round(v)));

    let nr: number, ng: number, nb: number;
    if (mode === 'lighten') {
        nr = clamp(r + (255 - r) * amount);
        ng = clamp(g + (255 - g) * amount);
        nb = clamp(b + (255 - b) * amount);
    } else {
        nr = clamp(r * (1 - amount));
        ng = clamp(g * (1 - amount));
        nb = clamp(b * (1 - amount));
    }

    // converte de volta pra HEX com dois dígitos
    const toHex = (v: number) => v.toString(16).padStart(2, '0');
    return `#${toHex(nr)}${toHex(ng)}${toHex(nb)}`;
}
