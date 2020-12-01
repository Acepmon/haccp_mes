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
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "회사정보등록",
        slug: "home",
      },
      {
        url: "/2",
        name: "생산담당자등록",
        slug: "home",
      },
      {
        url: "/3",
        name: "HACCP담당자등록",
        slug: "home",
      },
      {
        url: "/4",
        name: "HACCP서류등록",
        slug: "home",
        submenu: [
          {
            url: "/1",
            name: "HACCP 기준서 등록",
            slug: "home",
          },
          {
            url: "/2",
            name: "식품위생서류 등록",
            slug: "home",
          },
          {
            url: "/3",
            name: "HACCP 이행점검표",
            slug: "home",
          }
        ]
      },
      {
        url: "/5",
        name: "원/부자재 기준",
        slug: "home",
        submenu: [
          {
            url: "/1",
            name: "가공원료 기준등록",
            slug: "home",
          },
          {
            url: "/2",
            name: "원료 기준등록",
            slug: "home",
          },
          {
            url: "/3",
            name: "부자재 기준등록",
            slug: "home",
          }
        ]
      },
      {
        url: "/6",
        name: "생산제품등록",
        slug: "home",
      },
      {
        url: "/7",
        name: "원료배합비율",
        slug: "home",
      },
      {
        url: "/8",
        name: "공정순서관리",
        slug: "home",
        submenu: [
          {
            url: "/1",
            name: "전처리공정등록",
            slug: "home",
          },
          {
            url: "/2",
            name: "제조공정등록",
            slug: "home",
          }
        ]
      },
      {
        url: "/9",
        name: "구매기업정보등록",
        slug: "home",
      },
      {
        url: "/10",
        name: "납품기업정보등록",
        slug: "home",
      },
      {
        url: "/11",
        name: "정보보호관리",
        slug: "home",
      }
    ]
  },
  {
    url: "/2",
    name: "구매관리",
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "원료재고관리",
        slug: "home",
      },
      {
        url: "/2",
        name: "부자재재고관리",
        slug: "home",
      },
      {
        url: "/3",
        name: "구매관리",
        slug: "home",
      },
      {
        url: "/4",
        name: "입고관리",
        slug: "home",
      },
      {
        url: "/5",
        name: "재고이력관리",
        slug: "home",
        submenu: [
          {
            url: "/1",
            name: "(가공)원료재고이력",
            slug: "home",
          },
          {
            url: "/2",
            name: "부자재 재고이력",
            slug: "home",
          }
        ]
      }
    ]
  },
  {
    url: "/3",
    name: "주문처리",
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "B2B 주문처리",
        slug: "home",
      },
      {
        url: "/2",
        name: "B2C 주문처리",
        slug: "home",
      }
    ]
  },
  {
    url: "/4",
    name: "생산관리",
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "당일생산리스트",
        slug: "home",
      },
      {
        url: "/2",
        name: "원부자재출고",
        slug: "home",
      },
      {
        url: "/3",
        name: "제조사원업무등록",
        slug: "home",
      },
      {
        url: "/4",
        name: "사원별업무투입현황",
        slug: "home",
      }
    ]
  },
  {
    url: "/5",
    name: "출하관리",
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "제품재고현황",
        slug: "home",
      },
      {
        url: "/2",
        name: "출하관리",
        slug: "home",
      }
    ]
  },
  {
    url: "/6",
    name: "HACCP모니터링",
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "HACCP이행점검표",
        slug: "home",
      },
      {
        url: "/2",
        name: "CCP 모니터링",
        slug: "home",
      },
      {
        url: "/3",
        name: "CCP이탈관리",
        slug: "home",
      },
      {
        url: "/4",
        name: "CCP모니터링정보",
        slug: "home",
      },
      {
        url: "/5",
        name: "선행기준이탈관리",
        slug: "home",
      },
      {
        url: "/6",
        name: "제품이력관리",
        slug: "home",
      },
      {
        url: "/7",
        name: "시험검사관리",
        slug: "home",
      },
      {
        url: "/8",
        name: "KPI관리",
        slug: "home",
      }
    ]
  },
  {
    url: "/7",
    name: "자료관리",
    slug: "home",
    submenu: [
      {
        url: "/1",
        name: "판매정보",
        slug: "home",
      }
    ]
  }
]
