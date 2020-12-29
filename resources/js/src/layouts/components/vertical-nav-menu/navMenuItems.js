/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    url: "/1",
    name: "정보관리",
    slug: "정보관리",
    showSubmenuOn: '/1',
    submenu: [
      {
        url: "/1/1",
        name: "회사정보등록",
        slug: "회사정보등록",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/2",
        name: "HACCP담당자 관리",
        slug: "HACCP담당자 관리",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/3",
        name: "생산담당자 관리",
        slug: "생산담당자 관리",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/4",
        name: "HACCP서류등록",
        slug: "HACCP서류등록",
        showSubmenuOn: '/1',
        submenu: [
          {
            url: "/1/4/1",
            name: "HACCP 기준서 등록",
            slug: "HACCP 기준서 등록",
            showSubmenuOn: '/1',
          },
          {
            url: "/1/4/2",
            name: "식품위생서류 등록",
            slug: "식품위생서류 등록",
            showSubmenuOn: '/1',
          },
          {
            url: "/1/4/3",
            name: "HACCP 이행점검표",
            slug: "HACCP 이행점검표",
            showSubmenuOn: '/1',
          }
        ]
      },
      {
        url: "/1/5",
        name: "원/부자재 기준",
        slug: "원/부자재 기준",
        showSubmenuOn: '/1',
        submenu: [
          {
            url: "/1/5/1",
            name: "가공원료 기준등록",
            slug: "가공원료 기준등록",
            showSubmenuOn: '/1',
          },
          {
            url: "/1/5/2",
            name: "원료 기준등록",
            slug: "원료 기준등록",
            showSubmenuOn: '/1',
          },
          {
            url: "/1/5/3",
            name: "부자재 기준등록",
            slug: "부자재 기준등록",
            showSubmenuOn: '/1',
          }
        ]
      },
      {
        url: "/1/6",
        name: "원/부자재 관리",
        slug: "원/부자재 관리",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/7",
        name: "BOM 관리",
        slug: "BOM 관리",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/8",
        name: "공정순서관리",
        slug: "공정순서관리",
        showSubmenuOn: '/1',
        submenu: [
          {
            url: "/1/8/1",
            name: "전처리공정등록",
            slug: "전처리공정등록",
            showSubmenuOn: '/1',
          },
          {
            url: "/1/8/2",
            name: "제조공정등록",
            slug: "제조공정등록",
            showSubmenuOn: '/1',
          }
        ]
      },
      {
        url: "/1/9",
        name: "구매기업정보등록",
        slug: "구매기업정보등록",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/10",
        name: "납품기업정보등록",
        slug: "납품기업정보등록",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/11",
        name: "정보보호관리",
        slug: "정보보호관리",
        showSubmenuOn: '/1',
      }
    ]
  },
  {
    url: "/2",
    name: "생산관리",
    slug: "생산관리",
    showSubmenuOn: '/2',
    submenu: [
      {
        url: "/2/1",
        name: "제품별 표준공정등록",
        slug: "제품별 표준공정등록",
        showSubmenuOn: '/2',
      },
      {
        url: "/2/2",
        name: "부자재재고관리",
        slug: "부자재재고관리",
        showSubmenuOn: '/2',
      },
      {
        url: "/2/3",
        name: "구매관리",
        slug: "구매관리",
        showSubmenuOn: '/2',
      },
      {
        url: "/2/4",
        name: "입고관리",
        slug: "입고관리",
        showSubmenuOn: '/2',
      },
      {
        url: "/2/5",
        name: "재고이력관리",
        slug: "재고이력관리",
        showSubmenuOn: '/2',
        submenu: [
          {
            url: "/2/5/1",
            name: "(가공)원료재고이력",
            slug: "(가공)원료재고이력",
            showSubmenuOn: '/2',
          },
          {
            url: "/2/5/2",
            name: "부자재 재고이력",
            slug: "부자재 재고이력",
            showSubmenuOn: '/2',
          }
        ]
      }
    ]
  },
  {
    url: "/3",
    name: "거래처관리",
    slug: "거래처관리",
    showSubmenuOn: '/3',
    submenu: [
      {
        url: "/3/1",
        name: "B2B 주문처리",
        slug: "B2B 주문처리",
        showSubmenuOn: '/3',
      },
      {
        url: "/3/2",
        name: "B2C 주문처리",
        slug: "B2C 주문처리",
        showSubmenuOn: '/3',
      }
    ]
  },
  {
    url: "/4",
    name: "재고관리",
    slug: "재고관리",
    showSubmenuOn: '/4',
    submenu: [
      {
        url: "/4/1",
        name: "당일생산리스트",
        slug: "당일생산리스트",
        showSubmenuOn: '/4',
      },
      {
        url: "/4/2",
        name: "원부자재출고",
        slug: "원부자재출고",
        showSubmenuOn: '/4',
      },
      {
        url: "/4/3",
        name: "제조사원업무등록",
        slug: "제조사원업무등록",
        showSubmenuOn: '/4',
      },
      {
        url: "/4/4",
        name: "사원별업무투입현황",
        slug: "사원별업무투입현황",
        showSubmenuOn: '/4',
      }
    ]
  },
  {
    url: "/5",
    name: "출하관리",
    slug: "출하관리",
    showSubmenuOn: '/5',
    submenu: [
      {
        url: "/5/1",
        name: "제품재고현황",
        slug: "제품재고현황",
        showSubmenuOn: '/5',
      },
      {
        url: "/5/2",
        name: "출하관리",
        slug: "출하관리",
        showSubmenuOn: '/5',
      }
    ]
  },
  {
    url: "/6",
    name: "HACCP모니터링",
    slug: "HACCP모니터링",
    showSubmenuOn: '/6',
    submenu: [
      {
        url: "/6/1",
        name: "HACCP이행점검표",
        slug: "HACCP이행점검표",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/2",
        name: "CCP 모니터링",
        slug: "CCP 모니터링",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/3",
        name: "CCP이탈관리",
        slug: "CCP이탈관리",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/4",
        name: "CCP모니터링정보",
        slug: "CCP모니터링정보",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/5",
        name: "선행기준이탈관리",
        slug: "선행기준이탈관리",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/6",
        name: "제품이력관리",
        slug: "제품이력관리",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/7",
        name: "시험검사관리",
        slug: "시험검사관리",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/8",
        name: "KPI관리",
        slug: "KPI관리",
        showSubmenuOn: '/6',
      }
    ]
  },
  {
    url: "/7",
    name: "자료관리",
    slug: "자료관리",
    showSubmenuOn: '/7',
    submenu: [
      {
        url: "/7/1",
        name: "공통코드 관리",
        slug: "공통코드 관리",
        showSubmenuOn: '/7',
      },
      {
        url: "/7/2",
        name: "프로그램권한 권리",
        slug: "프로그램권한 권리",
        showSubmenuOn: '/7',
      },
      {
        url: "/7/3",
        name: "A Management",
        slug: "A Management",
        showSubmenuOn: '/7',
      },
      {
        url: "/7/4",
        name: "B Management",
        slug: "B Management",
        showSubmenuOn: '/7',
      }
    ]
  },
  {
    url: "/profile",
    name: "Profile",
    slug: "Profile",
    showSubmenuOn: '/profile',
    hideMenu: true,
    submenu: [
      {
        url: "/profile/general",
        name: "Profile General",
        slug: "Profile General",
        showSubmenuOn: '/profile',
      },
      {
        url: "/profile/password",
        name: "Change Password",
        slug: "Change Password",
        showSubmenuOn: '/profile',
      }
    ]
  }
]
