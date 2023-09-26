<?php
/**
 * Special:CourseRecommendations special page.
 *
 * @file
 * @author Winston Sung
 * @license GPL-2.0-or-later
 */

namespace MediaWiki\Extension\UCR\Specials;

use MediaWiki\Html\Html;
use MediaWiki\MainConfigNames;
// use MediaWiki\MediaWikiServices;
// use MediaWiki\Title\Title;
use MediaWiki\SpecialPage\SpecialPage;

/**
 * Provides the recommendation page with course tiles.
 *
 * @ingroup SpecialPage
 */
class SpecialCourseRecommendations extends SpecialPage {
	/** Private variables */

	public function __construct() {
		parent::__construct( 'CourseRecommendations' );
	}

	public function getDescription() {
		global $wgUCRMainPageUseSpecialCourseRecommendations;

		return $wgUCRMainPageUseSpecialCourseRecommendations ?
			$this->msg( 'special-course-recommendations-main-page-title' ) :
			$this->msg( 'special-course-recommendations' );
	}

	protected function getGroupName() {
		return 'wiki';
	}

	/**
	 * @param string|null $course_name
	 * @return array
	 */
	private function getTkugersApiResponseJson( ?string $course_name = null ) {
		$req = $this->getTkugersApiResponseJsonInternal( $course_name );

		// Validate whether response is JSON or not

		return [];
	}

	/**
	 * @param string|null $course_name
	 * @return string
	 */
	private function getTkugersApiResponseJsonInternal( ?string $course_name = null) {
		return $course_name ?
			file_get_contents( "http://localhost:5000/rscourse/$course_name" ) :
			file_get_contents( 'http://localhost:5000/course' );
	}

	public static function numberOfCourses() {
		return $count ?? null;
	}

	/**
	 * Callback for CachedStat
	 * @param string $code
	 * @param int $period
	 * @return array
	 */
	public static function getUserStats( $code, $period ) {
		return [
		];
	}

	/**
	 * Callback for CachedStat
	 * @param ProjectHandler $handler
	 * @return array
	 */
	public static function getUCRStats() {
		return [
			'courses' => $courses ?? null,
			'users' => $users ?? null,
		];
	}

	/**
	 * @return array
	 */
	public function getAllCourseNames(): array {
		return $this->getTkugersApiResponseJson() ?? [];
	}

	/**
	 * @param string $course_name
	 * @return string|null Valid course name or ''
	 */
	public function validateCourseName( string $course_name ) {
		if ( in_array( $course_name, $this->getAllCourseNames() ) ) {
			return $course_name;
		}

		return;
	}

	/**
	 * Return navigation.
	 *
	 * @return string
	 */
	public function getHeader() {
		$out = Html::openElement( 'header', [ 'class' => 'ucr-mainpage-header' ] );

		global $wgFooterIcons;
		$skin = $this->getSkin();
		foreach ( $wgFooterIcons as $class => $icons ) {
			foreach ( $icons as $icon ) {
				$out .= Html::openElement( 'div', [ 'class' => "row ucr-mainpage-header-$class" ] );
				$out .= $skin->makeFooterIcon( $icon );
				$out .= Html::closeElement( 'div' );
			}
		}
		$out .= Html::closeElement( 'header' );
		return $out;
	}

	public function getBanner() {
		$out = Html::openElement( 'div', [ 'class' => 'mw-header ucr-mainpage-header' ] );

/**
<header class="vector-header mw-header">
		<div class="vector-header-start">
			<nav class="vector-main-menu-landmark" aria-label="站台" role="navigation">
				
<div id="vector-main-menu-dropdown" class="vector-dropdown vector-main-menu-dropdown vector-button-flush-left vector-button-flush-right" lang="zh-Hant-TW" dir="ltr">
	<input type="checkbox" id="vector-main-menu-dropdown-checkbox" role="button" aria-haspopup="true" data-event-name="ui.dropdown-vector-main-menu-dropdown" class="vector-dropdown-checkbox " aria-label="主選單">
	<label id="vector-main-menu-dropdown-label" for="vector-main-menu-dropdown-checkbox" class="vector-dropdown-label cdx-button cdx-button--fake-button cdx-button--fake-button--enabled cdx-button--weight-quiet cdx-button--icon-only " aria-hidden="true"><span class="vector-icon mw-ui-icon-menu mw-ui-icon-wikimedia-menu"></span>

<span class="vector-dropdown-label-text">主選單</span>
	</label>
	<div class="vector-dropdown-content">


				<div id="vector-main-menu-unpinned-container" class="vector-unpinned-container">
		
<div id="vector-main-menu" class="vector-main-menu vector-pinnable-element">
	<div class="vector-pinnable-header vector-main-menu-pinnable-header vector-pinnable-header-unpinned" data-feature-name="main-menu-pinned" data-pinnable-element-id="vector-main-menu" data-pinned-container-id="vector-main-menu-pinned-container" data-unpinned-container-id="vector-main-menu-unpinned-container" data-saved-pinned-state="false">
	<div class="vector-pinnable-header-label">主選單</div>
	<button class="vector-pinnable-header-toggle-button vector-pinnable-header-pin-button" data-event-name="pinnable-header.vector-main-menu.pin">移至側邊欄</button>
	<button class="vector-pinnable-header-toggle-button vector-pinnable-header-unpin-button" data-event-name="pinnable-header.vector-main-menu.unpin">隱藏</button>
</div>

	
<div id="p-navigation" class="vector-menu mw-portlet mw-portlet-navigation" lang="zh-Hant-TW" dir="ltr">
	<div class="vector-menu-heading">
		導覽
	</div>
	<div class="vector-menu-content">
		
		<ul class="vector-menu-content-list">
			
			<li id="n-mainpage-description" class="mw-list-item"><a href="/wiki/Wikipedia:%E9%A6%96%E9%A1%B5" title="前往首頁[alt-shift-z]" accesskey="z"><span>首頁</span></a></li><li id="n-indexpage" class="mw-list-item"><a href="/wiki/Wikipedia:%E5%88%86%E7%B1%BB%E7%B4%A2%E5%BC%95" title="以分類索引搜尋中文維基百科"><span>分類索引</span></a></li><li id="n-Featured_content" class="mw-list-item"><a href="/wiki/Portal:%E7%89%B9%E8%89%B2%E5%85%A7%E5%AE%B9" title="查看中文維基百科的特色內容"><span>特色內容</span></a></li><li id="n-currentevents" class="mw-list-item"><a href="/wiki/Portal:%E6%96%B0%E8%81%9E%E5%8B%95%E6%85%8B" title="提供當前新聞事件的背景資料"><span>新聞動態</span></a></li><li id="n-recentchanges" class="mw-list-item"><a href="/wiki/Special:%E6%9C%80%E8%BF%91%E6%9B%B4%E6%94%B9" title="列出維基百科中的最近修改[alt-shift-r]" accesskey="r"><span>近期變更</span></a></li><li id="n-randompage" class="mw-list-item"><a href="/wiki/Special:%E9%9A%8F%E6%9C%BA%E9%A1%B5%E9%9D%A2" title="隨機載入一個頁面[alt-shift-x]" accesskey="x"><span>隨機條目</span></a></li><li id="n-sitesupport" class="mw-list-item"><a href="https://donate.wikimedia.org/?utm_source=donate&amp;utm_medium=sidebar&amp;utm_campaign=spontaneous&amp;uselang=zh-hans" title="如果您在維基百科受益良多，您可以考慮贊助我們"><span>資助維基百科</span></a></li>
		</ul>
		
	</div>
</div>

	
	
<div id="p-help" class="vector-menu mw-portlet mw-portlet-help" lang="zh-Hant-TW" dir="ltr">
	<div class="vector-menu-heading">
		說明
	</div>
	<div class="vector-menu-content">
		
		<ul class="vector-menu-content-list">
			
			<li id="n-help" class="mw-list-item"><a href="/wiki/Help:%E7%9B%AE%E5%BD%95" title="尋求幫助"><span>說明</span></a></li><li id="n-portal" class="mw-list-item"><a href="/wiki/Wikipedia:%E7%A4%BE%E7%BE%A4%E9%A6%96%E9%A1%B5" title="關於本計畫、你可以做什麼、應該如何做"><span>維基社群</span></a></li><li id="n-policy" class="mw-list-item"><a href="/wiki/Wikipedia:%E6%96%B9%E9%87%9D%E8%88%87%E6%8C%87%E5%BC%95" title="查看維基百科的方針和指引"><span>方針與指引</span></a></li><li id="n-villagepump" class="mw-list-item"><a href="/wiki/Wikipedia:%E4%BA%92%E5%8A%A9%E5%AE%A2%E6%A0%88" title="參與維基百科社群的討論"><span>互助客棧</span></a></li><li id="n-Information_desk" class="mw-list-item"><a href="/wiki/Wikipedia:%E7%9F%A5%E8%AF%86%E9%97%AE%E7%AD%94" title="解答任何與維基百科無關的問題的地方"><span>知識問答</span></a></li><li id="n-conversion" class="mw-list-item"><a href="/wiki/Wikipedia:%E5%AD%97%E8%AF%8D%E8%BD%AC%E6%8D%A2" title="提出字詞轉換請求"><span>字詞轉換</span></a></li><li id="n-IRC" class="mw-list-item"><a href="/wiki/Wikipedia:IRC%E8%81%8A%E5%A4%A9%E9%A2%91%E9%81%93"><span>IRC即時聊天</span></a></li><li id="n-contact" class="mw-list-item"><a href="/wiki/Wikipedia:%E8%81%94%E7%BB%9C%E6%88%91%E4%BB%AC" title="如何聯絡維基百科"><span>聯絡我們</span></a></li><li id="n-about" class="mw-list-item"><a href="/wiki/Wikipedia:%E5%85%B3%E4%BA%8E" title="查看維基百科的簡介"><span>關於維基百科</span></a></li>
		</ul>
		
	</div>
</div>

	
</div>

				</div>

	</div>
</div>

		</nav>
			
<a href="/wiki/Wikipedia:%E9%A6%96%E9%A1%B5" class="mw-logo">
	<img class="mw-logo-icon" src="/static/images/icons/wikipedia.png" alt="" aria-hidden="true" height="50" width="50">
	<span class="mw-logo-container">
		<img class="mw-logo-wordmark" alt="維基百科" src="/static/images/mobile/copyright/wikipedia-wordmark-zh.svg" style="width: 6.5625em; height: 1.375em;">
		<img class="mw-logo-tagline" alt="自由的百科全書" src="/static/images/mobile/copyright/wikipedia-tagline-zh.svg" width="103" height="14" style="width: 6.4375em; height: 0.875em;">
	</span>
</a>

		</div>
		<div class="vector-header-end">
			
<div id="p-search" role="search" class="vector-search-box-vue  vector-search-box-collapses vector-search-box-show-thumbnail vector-search-box-auto-expand-width vector-search-box">
	<a href="/wiki/Special:%E6%90%9C%E7%B4%A2" class="cdx-button cdx-button--fake-button cdx-button--fake-button--enabled cdx-button--weight-quiet cdx-button--icon-only search-toggle" id="" title="搜尋維基百科[alt-shift-f]" accesskey="f"><span class="vector-icon mw-ui-icon-search mw-ui-icon-wikimedia-search"></span>

<span>搜尋</span>
	</a>
	<div class="vector-typeahead-search-container">
		<div class="cdx-typeahead-search cdx-typeahead-search--show-thumbnail cdx-typeahead-search--auto-expand-width">
			<form action="/w/index.php" id="searchform" class="cdx-search-input cdx-search-input--has-end-button">
				<div id="simpleSearch" class="cdx-search-input__input-wrapper" data-search-loc="header-moved">
					<div class="cdx-text-input cdx-text-input--has-start-icon">
						<input class="cdx-text-input__input" type="search" name="search" placeholder="搜尋維基百科" aria-label="搜尋維基百科" autocapitalize="sentences" title="搜尋維基百科[alt-shift-f]" accesskey="f" id="searchInput" autocomplete="off">
						<span class="cdx-text-input__icon cdx-text-input__start-icon"></span>
					</div>
					<input type="hidden" name="title" value="Special:搜索">
				</div>
				<button class="cdx-button cdx-search-input__end-button">搜尋</button>
			</form>
		</div>
	</div>
</div>

			<nav class="vector-user-links" aria-label="個人工具" role="navigation">
	
<div id="p-vector-user-menu-overflow" class="vector-menu mw-portlet mw-portlet-vector-user-menu-overflow" lang="zh-Hant-TW" dir="ltr">
	<div class="vector-menu-content">
		
		<ul class="vector-menu-content-list">
			
			<li id="pt-createaccount-2" class="user-links-collapsible-item mw-list-item"><a href="/w/index.php?title=Special:%E5%88%9B%E5%BB%BA%E8%B4%A6%E6%88%B7&amp;returnto=Wikipedia%3A%E9%A6%96%E9%A1%B5" title="我們會鼓勵您建立一個帳號並且登入，即使這不是必要的動作。"><span>建立帳號</span></a></li><li id="pt-login-2" class="user-links-collapsible-item mw-list-item"><a href="/w/index.php?title=Special:%E7%94%A8%E6%88%B7%E7%99%BB%E5%BD%95&amp;returnto=Wikipedia%3A%E9%A6%96%E9%A1%B5" title="建議您先登入，但並非必要。[alt-shift-o]" accesskey="o"><span>登入</span></a></li>
		</ul>
		
	</div>
</div>

	
<div id="vector-user-links-dropdown" class="vector-dropdown vector-user-menu vector-button-flush-right vector-user-menu-logged-out" title="更多選項" lang="zh-Hant-TW" dir="ltr">
	<input type="checkbox" id="vector-user-links-dropdown-checkbox" role="button" aria-haspopup="true" data-event-name="ui.dropdown-vector-user-links-dropdown" class="vector-dropdown-checkbox " aria-label="個人工具">
	<label id="vector-user-links-dropdown-label" for="vector-user-links-dropdown-checkbox" class="vector-dropdown-label cdx-button cdx-button--fake-button cdx-button--fake-button--enabled cdx-button--weight-quiet cdx-button--icon-only " aria-hidden="true"><span class="vector-icon mw-ui-icon-ellipsis mw-ui-icon-wikimedia-ellipsis"></span>

<span class="vector-dropdown-label-text">個人工具</span>
	</label>
	<div class="vector-dropdown-content">


		
<div id="p-personal" class="vector-menu mw-portlet mw-portlet-personal user-links-collapsible-item" title="使用者選單" lang="zh-Hant-TW" dir="ltr">
	<div class="vector-menu-content">
		
		<ul class="vector-menu-content-list">
			
			<li id="pt-createaccount" class="user-links-collapsible-item mw-list-item"><a href="/w/index.php?title=Special:%E5%88%9B%E5%BB%BA%E8%B4%A6%E6%88%B7&amp;returnto=Wikipedia%3A%E9%A6%96%E9%A1%B5" title="我們會鼓勵您建立一個帳號並且登入，即使這不是必要的動作。"><span class="vector-icon mw-ui-icon-userAdd mw-ui-icon-wikimedia-userAdd"></span> <span>建立帳號</span></a></li><li id="pt-login" class="user-links-collapsible-item mw-list-item"><a href="/w/index.php?title=Special:%E7%94%A8%E6%88%B7%E7%99%BB%E5%BD%95&amp;returnto=Wikipedia%3A%E9%A6%96%E9%A1%B5" title="建議您先登入，但並非必要。[alt-shift-o]" accesskey="o"><span class="vector-icon mw-ui-icon-logIn mw-ui-icon-wikimedia-logIn"></span> <span>登入</span></a></li>
		</ul>
		
	</div>
</div>

<div id="p-user-menu-anon-editor" class="vector-menu mw-portlet mw-portlet-user-menu-anon-editor" lang="zh-Hant-TW" dir="ltr">
	<div class="vector-menu-heading">
		用於已登出編輯者的頁面 <a href="/wiki/Help:%E6%96%B0%E6%89%8B%E5%85%A5%E9%96%80" aria-label="了解更多有關編輯"><span>了解更多</span></a>
	</div>
	<div class="vector-menu-content">
		
		<ul class="vector-menu-content-list">
			
			<li id="pt-anoncontribs" class="mw-list-item"><a href="/wiki/Special:%E6%88%91%E7%9A%84%E8%B4%A1%E7%8C%AE" title="由此 IP 位址編輯的清單[alt-shift-y]" accesskey="y"><span>貢獻</span></a></li><li id="pt-anontalk" class="mw-list-item"><a href="/wiki/Special:%E6%88%91%E7%9A%84%E8%AE%A8%E8%AE%BA%E9%A1%B5" title="對於來自此IP地址編輯的討論[alt-shift-n]" accesskey="n"><span>討論</span></a></li>
		</ul>
		
	</div>
</div>

	
	</div>
</div>

</nav>

		</div>
	</header>
 */


		global $wgFooterIcons;
		$skin = $this->getSkin();
		foreach ( $wgFooterIcons as $class => $icons ) {
			foreach ( $icons as $icon ) {
				$out .= Html::openElement( 'div', [ 'class' => "row ucr-mainpage-header-$class" ] );
				$out .= $skin->makeFooterIcon( $icon );
				$out .= Html::closeElement( 'div' );
			}
		}
		$out .= Html::closeElement( 'div' );
		return $out;
	}

	public function courseSelector() {
		return $html ?? '';
	}

	public function getSearchBar() {
		$out = Html::openElement( 'form',
			[
				'class' => 'row twn-mainpage-search',
				'action' => SpecialPage::getTitleFor( 'CourseRecommendations' )->getLocalURL(),
			] );

		$out .= Html::element( 'input',
			[
				'class' => 'ten columns searchbox',
				'id' => 'twnmp-search-field',
				'placeholder' => $this->msg( 'special-course-recommendations-search-placeholder' )->text(),
				'type' => 'search',
				'name' => 'query',
				'dir' => $this->getLanguage()->getDir(),
			] );

		$out .= Html::element( 'button',
			[
				'class' => 'mw-ui-button mw-ui-progressive',
				'type' => 'submit',
				'id' => 'twnmp-search-button',
			],
			$this->msg( 'special-course-recommendations-search-button' )->text() );
		$out .= Html::closeElement( 'form' );

		return $out;
	}

	/**
	 * @param string $id Course ID.
	 * @return string HTML.
	 */
	protected function getCourseActions( $id ) {
		$user = $this->getUser();
		$title = SpecialPage::getTitleFor( 'Translate' );

		$view = Html::element( 'a', [
			'class' => 'translate',
			'href' => $title->getLocalURL( [ 'group' => $id ] )
		], $this->msg( 'twnmp-view-link' )->text() );

		if ( $user->isAnon() ) {
			return <<<HTML
<div class="twelve columns action">$view</div>

HTML;
		} else {
			return '';
		}
	}

	/**
	 * @param string $course_name
	 * @return string HTML.
	 */
	private function getCourseTile( string $course_name ) {
		return "";
	}

	/**
	 * @param string|null $course_name
	 * @return string HTML.
	 */
	private function getCourseTiles( ?string $course_name = null ) {
		global $wgUCRMaxCourseTiles;

		$tiles = [];
		$courses = $this->getTkugersApiResponseJson();
		foreach ( $courses as $course ) {
			if ( count( $tiles ) <= $wgUCRMaxCourseTiles ) {
				$tile['main'][] = $this->getCourseTile( $course );
			} else {
				$tile['more'][] = $this->getCourseTile( $course );
			}
		}

		return $tilesHtml ?? '';
	}

	public function getFooter() {
		$out = Html::openElement( 'footer', [ 'class' => 'ucr-mainpage-footer' ] );

		global $wgFooterIcons;
		$skin = $this->getSkin();
		foreach ( $wgFooterIcons as $class => $icons ) {
			foreach ( $icons as $icon ) {
				$out .= Html::openElement( 'div', [ 'class' => "row ucr-mainpage-footer-$class" ] );
				$out .= $skin->makeFooterIcon( $icon );
				$out .= Html::closeElement( 'div' );
			}
		}
		$out .= Html::closeElement( 'footer' );
		return $out;
	}

	/**
	 * @param string|null $course_name
	 */
	public function getContent( ?string $course_name = null ) {
		$output = '';

		$output .= Html::openElement( 'div', [ 'class' => 'grid ucr-mainpage' ] );
		$output .= $this->getHeader();
		$output .= Html::openElement( 'main' );
		$output .= $this->getBanner();
		$output .= $this->getSearchBar();
		$output .= Html::closeElement( 'main' );
		$output .= $this->getFooter();
		$output .= Html::closeElement( 'div' );
		return $output;
	}

	/**
	 * @inheritDoc
	 */
	public function execute( $subpage ) {
		global $wgUCRMainPageUseSpecialCourseRecommendations;

		$request = $this->getRequest();
		$out = $this->getOutput();
		$skin = $this->getSkin();

		$search_query = trim( $request->getText( 'query' ) );
		$search_full_text = $request->getText( 'fulltext' );
		$course_name = $this->validateCourseName( $search_query );
		if ( ( !$search_full_text && $course_name !== null && $course_name !== '' ) ) {
			$course_name = $course_name !== '' ? $course_name : null;
			$url = SpecialPage::getTitleFor( 'CourseRecommendations', $course_name )->getLocalURL();
			$out->redirect( $url );
		}

		$this->setHeaders();
		$out->setArticleBodyOnly( true );
		$out->loadSkinModules( $skin );

		if ( $wgUCRMainPageUseSpecialCourseRecommendations ) {
			$out->setHTMLTitle( $this->msg( 'pagetitle-view-mainpage' )->text() );
		}

		// Enable this if you need useful debugging information
		// $out->addHtml( MWDebug::getDebugHTML( $this->getContext() ) );
		$this->getHookContainer()->run( 'BeforePageDisplay', [ &$out, &$skin ] );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=0.5' );

		// We very much do want this page to be indexed even though special pages normally aren't
		$out->setRobotPolicy( $this->getConfig()->get( MainConfigNames::DefaultRobotPolicy ) );

		// These add modules so this has to be called before headElement
		$out->addModules( 'ext.ucr.common' );
		$out->addModuleStyles( 'ext.ucr.special.courserecommendations.styles' );
		$out->addModuleStyles( 'mediawiki.ui.button' );

		// Forcing wgULSPosition to personal to mimick that behavior regardless
		// of the position of the uls trigger in other pages.
		$out->addJsConfigVars( 'wgULSPosition', 'personal' );

		$course_name = $subpage;
		$output = $this->getContent( $course_name );

		$out->addHTML(
			$out->headElement( $skin ) .
			$output .
			($course_name !== '' ? "\$course_name = $course_name" : '') . // For testing
			($search_query !== '' ? "\$search_query = $search_query" : '') . // For testing
			$out->getBottomScripts() .
			'</body></html>'
		);
	}
}
