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
      // {
      //   url: "/1/5",
      //   name: "원/부자재 기준",
      //   slug: "원/부자재 기준",
      //   showSubmenuOn: '/1',
      //   submenu: [
      //     {
      //       url: "/1/5/1",
      //       name: "가공원료 기준등록",
      //       slug: "가공원료 기준등록",
      //       showSubmenuOn: '/1',
      //     },
      //     {
      //       url: "/1/5/2",
      //       name: "원료 기준등록",
      //       slug: "원료 기준등록",
      //       showSubmenuOn: '/1',
      //     },
      //     {
      //       url: "/1/5/3",
      //       name: "부자재 기준등록",
      //       slug: "부자재 기준등록",
      //       showSubmenuOn: '/1',
      //     }
      //   ]
      // },
      {
        url: "/1/6",
        name: "원/부자재 관리",
        slug: "원/부자재 관리",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/6/1",
        name: "원/부자재 단위관리",
        slug: "원/부자재 단위관리",
        showSubmenuOn: '/1',
      },
      {
        url: "/1/7",
        name: "BOM 관리",
        slug: "BOM 관리",
        showSubmenuOn: '/1',
      },
      // {
      //   url: "/1/8",
      //   name: "공정순서관리",
      //   slug: "공정순서관리",
      //   showSubmenuOn: '/1',
      //   submenu: [
      //     {
      //       url: "/1/8/1",
      //       name: "전처리공정등록",
      //       slug: "전처리공정등록",
      //       showSubmenuOn: '/1',
      //     },
      //     {
      //       url: "/1/8/2",
      //       name: "제조공정등록",
      //       slug: "제조공정등록",
      //       showSubmenuOn: '/1',
      //     }
      //   ]
      // },
      // {
      //   url: "/1/9",
      //   name: "구매기업정보등록",
      //   slug: "구매기업정보등록",
      //   showSubmenuOn: '/1',
      // },
      // {
      //   url: "/1/10",
      //   name: "납품기업정보등록",
      //   slug: "납품기업정보등록",
      //   showSubmenuOn: '/1',
      // },
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
        name: "생산지시 등록",
        slug: "생산지시 등록",
        showSubmenuOn: '/2',
      },
      {
        url: "/2/3",
        name: "생산지시 조회",
        slug: "생산지시 조회",
        showSubmenuOn: '/2',
      },
      {
        url: "/2/4",
        name: "작업자 배치",
        slug: "작업자 배치",
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
        name: "거래처 등록",
        slug: "거래처 등록",
        showSubmenuOn: '/3',
      },
      {
        url: "/3/2",
        name: "거래처 조회",
        slug: "거래처 조회",
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
        name: "시리얼/Lot 등록",
        slug: "시리얼/Lot 등록",
        showSubmenuOn: '/4',
      },
      {
        url: "/4/2",
        name: "생산불출 등록",
        slug: "생산불출 등록",
        showSubmenuOn: '/4',
      },
      {
        url: "/4/3",
        name: "창고별 재고현황",
        slug: "창고별 재고현황",
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
  // {
  //   url: "/5",
  //   name: "출하관리",
  //   slug: "출하관리",
  //   showSubmenuOn: '/5',
  //   submenu: [
  //     {
  //       url: "/5/1",
  //       name: "제품재고현황",
  //       slug: "제품재고현황",
  //       showSubmenuOn: '/5',
  //     },
  //     {
  //       url: "/5/2",
  //       name: "출하관리",
  //       slug: "출하관리",
  //       showSubmenuOn: '/5',
  //     }
  //   ]
  // },
  {
    url: "/6",
    name: "HACCP모니터링",
    slug: "HACCP모니터링",
    showSubmenuOn: '/6',
    submenu: [
      {
        url: "/6/1",
        name: "CCP 모니터링",
        slug: "CCP 모니터링",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/2",
        name: "CCP 이탈한계설정",
        slug: "CCP 이탈한계설정",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/3",
        name: "CCP 이탈정보",
        slug: "CCP 이탈정보",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/4",
        name: "CCP 자료 조회",
        slug: "CCP 자료 조회",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/5",
        name: "HACCP 점검결과",
        slug: "HACCP 점검결과",
        showSubmenuOn: '/6',
      },
      {
        url: "/6/6",
        name: "시험검사관리",
        slug: "시험검사관리",
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
        name: "사용자 로그이력",
        slug: "사용자 로그이력",
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
      },
      {
        url: "/profile/notifications",
        name: "Notifications",
        slug: "Notifications",
        showSubmenuOn: '/profile',
      }
    ]
  }
]
