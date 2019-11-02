<?php

/** Controlls provider class - plugs controls into pages
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Framework
 * @subpackage classes.module.web.controls
 * @access public
 **/
class CmsControlsProvider
{

    /**
     * Method plugs controls into page
     * @param     Page    $page   PAge object
     * @access    public
     **/
    static function AddControls(&$page){
        $page->Kernel->ImportClass("web.controls.structurecontrol", "StructureControl", "content");
        $page->AddControl(new StructureControl("cms_page", "cms_page"));

        $page->Kernel->ImportClass("web.controls.sitestructurecontrol", "SiteStructureControl", "content");
        $page->AddControl(new SiteStructureControl("cms_structure", "cms_structure"));

        $page->Kernel->ImportClass("web.controls.menucontrol", "MenuControl", "content");
        $page->AddControl(new MenuControl("cms_menu", "cms_menu"));

        $page->Kernel->ImportClass("web.controls.contentcontrol", "ContentControl", "content");
        $page->AddControl(new ContentControl("cms_content", "cms_content"));

	    if (Engine::isPackageExists($page->Kernel, "banner")) {
            $page->Kernel->ImportClass("web.controls.bannerscontrol", "BannersControl", "banner");
            $page->AddControl(new BannersControl("cms_banners", "cms_banners"));
        }

        if (Engine::isPackageExists($page->Kernel, "context")) {
            $page->Kernel->ImportClass("web.controls.contextcontrol", "ContextControl", "context");
            $page->AddControl(new ContextControl("cms_context", "cms_context"));
        }

        //--include publications control
        if (Engine::isPackageExists($page->Kernel, "publications")) {
            $page->Kernel->ImportClass("web.controls.publicationcontrol", "PublicationControl", "publications");
            $page->AddControl(new PublicationControl("cms_publications", "cms_publications"));
        }
        //--include comments control
        if (Engine::isPackageExists($page->Kernel, "comments")) {
            $page->Kernel->ImportClass("web.controls.commentscontrol", "CommentsControl", "comments");
            $page->AddControl(new CommentsControl("cms_comments", "cms_comments"));
        }
        //--include statistics control
        if (Engine::isPackageExists($page->Kernel, "stat")) {
            $page->Kernel->ImportClass("web.controls.statcollectorcontrol", "StatCollectorControl", "stat");
            $page->AddControl(new StatCollectorControl("statcollector", "statcollector"));
        }
    }
}
?>