<?php

namespace {

    use DNADesign\Elemental\Models\ElementalArea;
    use DNADesign\Elemental\Models\ElementContent;
    use SilverStripe\CMS\Model\SiteTree;

    /**
     * Class Page
     */
    class Page extends SiteTree
    {
        /**
         *
         */
        protected function onBeforeWrite()
        {
            parent::onBeforeWrite();

            if (!$this->MetaDescription) {
                $this->MetaDescription = $this->generateMetaDescription();
            }
        }

        /**
         * @return string|null
         */
        protected function generateMetaDescription()
        {
            if ($this->Content) {
                return $this->dbObject('Content')->FirstParagraph();
            }

            if ($this->hasMethod('ElementalArea')) {
                /** @var ElementalArea $area */
                if ($area = $this->ElementalArea()) {
                    if ($content = $area->Elements()->filter('ClassName', ElementContent::class)->first()) {
                        return $content->dbObject('HTML')->FirstParagraph();
                    }
                }
            }

            return null;
        }

        /**
         * @return array
         */
        public function MetaComponents()
        {
            $tags = parent::MetaComponents();
            $this->extend('updateMetaComponents', $tags);
            return $tags;
        }
    }
}
