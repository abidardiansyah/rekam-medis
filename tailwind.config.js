/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: ['class', '[data-pc-theme="dark"]'],
  theme: {
    fontFamily: {
      sans: ['"Inter var", sans-serif', { fontFeatureSettings: '"salt"' }]
    },
    container: {
      center: true,
      padding: '2rem'
    },
    extend: {
      fontSize: {
        sm: '0.75rem',
        base: '0.875rem',
        'f-h1': '38px',
        'f-h2': '30px',
        'f-h3': '24px',
        'f-h4': '20px',
        'f-h5': '16px',
        'f-h6': '14px'
      },
      spacing: {
        'sidebar-width': '280px',
        'header-height': '74px',
        'topbar-height': '60px',
        'sidebar-collapsed-width': '100px',
        'sidebar-collapsed-active-width': '300px',
        'sidebar-tab-width': '75px',
        'sidebar-tab-navbar-width': '320px'
      },
      colors: {
        theme: {
          headings: '#1d2630',
          bodycolor: '#131920',
          bodybg: '#f8f9fa',
          border: '#e7eaee',
          secondarytextcolor: 'rgba(33, 37, 41, 0.75)',
          sidebarcolor: '#5b6b79',
          sidebarbordercolor: '#bec8d0',
          sidebaruserbg: '#f3f5f7',
          headerbg: 'rgba( 248,249,250, 0.7)',
          headercolor: '#5b6b79',
          activebg: '#f3f5f7',
          horizontalsubmenubg: '#fff',
          horizontalsubmenucolor: '#5b6b79',
          cardbg: '#fff',
          inputbg: '#fff',
          inputborder: '#bec8d0'
        },
        themedark: {
          headings: 'rgba(255, 255, 255, 0.8)',
          bodycolor: '#bfbfbf',
          bodybg: '#131920',
          border: '#303f50',
          secondarytextcolor: '#748892',
          sidebarcolor: 'rgba(255, 255, 255, 0.5)',
          sidebarbordercolor: '#242d39',
          sidebaruserbg: '#1b232d',
          headerbg: 'rgba( 19, 25, 32, 0.5)',
          headercolor: 'rgba(255, 255, 255, 0.8)',
          activebg: '#19212a',
          horizontalsubmenubg: '#263240',
          horizontalsubmenucolor: '#bfbfbf',
          cardbg: '#1b232d',
          inputbg: '#263240',
          inputborder: '#303f50'
        },
        primary: {
          DEFAULT: '#4680FF',
          50: '#EBF1FF',
          100: '#D7E3FF',
          200: '#B0C7FF',
          300: '#88ABFF',
          400: '#618FFF',
          500: '#4680FF',
          600: '#0E5CFF',
          700: '#0047D5',
          800: '#00349D',
          900: '#002165',
          950: '#001649'
        },
        secondary: {
          DEFAULT: '#5B6B79',
          50: '#F2F4F5',
          100: '#E1E5E8',
          200: '#BEC6CE',
          300: '#9BA8B4',
          400: '#788A99',
          500: '#5B6B79',
          600: '#495662',
          700: '#38424A',
          800: '#262D33',
          900: '#15191C',
          950: '#0C0E10'
        },
        success: {
          DEFAULT: '#2CA87F',
          50: '#dff2ec',
          100: '#c0e5d9',
          200: '#96d4bf',
          300: '#6bc2a5',
          400: '#4cb592',
          500: '#2ca87f',
          600: '#27a077',
          700: '#21976c',
          800: '#1b8d62',
          900: '#107d4f',
          950: '#0a5736'
        },
        danger: {
          DEFAULT: '#DC2626',
          50: '#fadede',
          100: '#f5bebe',
          200: '#ee9393',
          300: '#e76767',
          400: '#e14747',
          500: '#dc2626',
          600: '#d82222',
          700: '#d31c1c',
          800: '#ce1717',
          900: '#c50d0d',
          950: '#a50909'
        },
        warning: {
          DEFAULT: '#E58A00',
          50: '#fbedd9',
          100: '#f7dcb3',
          200: '#f2c580',
          300: '#edad4d',
          400: '#e99c26',
          500: '#e58a00',
          600: '#e28200',
          700: '#de7700',
          800: '#da6d00',
          900: '#d35a00',
          950: '#b54d00'
        },
        info: {
          DEFAULT: '#3EC9D6',
          50: '#e2f7f9',
          100: '#c5eff3',
          200: '#9fe4eb',
          300: '#78d9e2',
          400: '#5bd1dc',
          500: '#3ec9d6',
          600: '#38c3d1',
          700: '#30bccc',
          800: '#28b5c6',
          900: '#1ba9bc',
          950: '#148999'
        },
        dark: {
          DEFAULT: '#212529',
          50: '#E6E8EB',
          100: '#CED2D7',
          200: '#9EA7B1',
          300: '#6E7C89',
          400: '#485059',
          500: '#212529',
          600: '#1A1D21',
          700: '#131618',
          800: '#0D0E10',
          900: '#060607',
          950: '#020303'
        }
      }
    }
  },
  plugins: [],
}
