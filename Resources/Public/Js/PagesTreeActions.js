Ext.onReady(function () {
    Ext.apply(TYPO3.Components.PageTree.Actions, {
        loadsPageIconChanger: function(node, tree) {
            TYPO3.RtPagesTreeIcons.ClickmenuAction.loadsPageIconChanger(
                node.attributes.nodeData,
                function(response) {
                    if (response) {
                        //Select the page icon changer module
                        top.TYPO3.ModuleMenu.App.showModule('web_RtPagesTreeIconsMod1');
                        //Select the page tree
                        if (top && top.TYPO3.Backend.NavigationContainer.PageTree) {
                            top.TYPO3.Backend.NavigationContainer.PageTree.select(response.pageId);
                        }
                        //Redirect to page icon changer module
                        //TYPO3.Backend.ContentContainer.setUrl(response.modUrl + '&pageId=' + response.pageId);
                    }
                },
                this
            );
        }
    });
});