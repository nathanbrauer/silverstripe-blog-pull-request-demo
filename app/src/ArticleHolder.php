<?php

namespace {

    use DNADesign\Elemental\Models\ElementalArea;
    use DNADesign\Elemental\Models\ElementContent;
    use SilverStripe\Blog\Model\Blog;
    use SilverStripe\Blog\Model\BlogPost;
    use SilverStripe\ORM\DB;
    use SilverStripe\ORM\FieldType\DBDatetime;
    use SilverStripe\Versioned\Versioned;

    /**
     * Class ArticleHolder
     * @package Sargento\CPD\Page
     */
    class ArticleHolder extends Blog
    {
        /**
         * @var string
         */
        private static $singular_name = 'Article Holder';

        /**
         * @var string
         */
        private static $plural_name = 'Article Holders';

        /**
         * @var string
         */
        private static $hide_ancestor = Blog::class;

        /**
         * @var string
         */
        private static $table_name = 'ArticleHolder';

        /**
         * @return string
         */
        public function getLumberjackTitle()
        {
            return 'Articles';
        }

        public function requireDefaultRecords()
        {
            parent::requireDefaultRecords();

            if (self::get()->count()) {
                return;
            }

            $FirstArticleHolder = self::create();
            $FirstArticleHolder->Title = 'Articles';
            $FirstArticleHolder->write();
            $FirstArticleHolder->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            $FirstArticleHolder->flushCache();
            DB::alteration_message('Articles page created', 'created');

            /**
             * PUBLISHED DATE - UNSET
             */
            $ElementalArea = new ElementalArea();
            $ElementalArea->OwnerClassName = BlogPost::class;
            $ElementalArea->write();
            DB::alteration_message('ElementalArea for BlogPost #1 created', 'created');

            $FirstBlog = new BlogPost();
            $FirstBlog->ParentID = $FirstArticleHolder->ID;
            $FirstBlog->ElementalAreaID = $ElementalArea->ID;
            $FirstBlog->Title = 'NULL PublishedDate';
            $FirstBlog->Content = <<<HTML
<h3>Without the patch, associated Elemental Blocks will appear below for:</h3>
<ul>
<li>Logged-in users: <strong style="color:green;">YES</strong></li>
<li>Logged-out users: <strong style="color:red;">NO</strong></li>
</ul>
HTML;
            $FirstBlog->write();
            DB::alteration_message('BlogPost #1 for Articles created', 'created');

            $ElementContent = new ElementContent();
            $ElementContent->Sort = 1;
            $ElementContent->ParentID = $ElementalArea->ID;
            $ElementContent->ShowTitle = true;
            $ElementContent->Title = 'This is an ElementContent block with a visible Title and HTML content';
            $ElementContent->HTML = <<<HTML
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Res enim concurrent contrariae. <mark>Non semper, inquam;</mark> </p>

<ol>
	<li>Nihil est enim, de quo aliter tu sentias atque ego, modo commutatis verbis ipsas res conferamus.</li>
	<li>Facit enim ille duo seiuncta ultima bonorum, quae ut essent vera, coniungi debuerunt;</li>
</ol>


<blockquote cite='http://loripsum.net'>
	Aut, si nihil malum, nisi quod turpe, inhonestum, indecorum, pravum, flagitiosum, foedum-ut hoc quoque pluribus nominibus insigne faciamus-, quid praeterea dices esse fugiendum?
</blockquote>


<ul>
	<li>In qua quid est boni praeter summam voluptatem, et eam sempiternam?</li>
	<li>Ab his oratores, ab his imperatores ac rerum publicarum principes extiterunt.</li>
	<li>Ut optime, secundum naturam affectum esse possit.</li>
	<li>Ego quoque, inquit, didicerim libentius si quid attuleris, quam te reprehenderim.</li>
</ul>


<p><b>Omnia peccata paria dicitis.</b> Si longus, levis. Duo Reges: constructio interrete. Idem adhuc; <b>Confecta res esset.</b> </p>
HTML;
            $ElementContent->write();
            DB::alteration_message('ElementContent #1 for BlogPost #1 created', 'created');

            $ElementContent = new ElementContent();
            $ElementContent->Sort = 2;
            $ElementContent->ParentID = $ElementalArea->ID;
            $ElementContent->ShowTitle = true;
            $ElementContent->Title = 'A second ElementContent block';
            $ElementContent->HTML = <<<HTML
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tu quidem reddes; Negare non possum. Duo Reges: constructio interrete. <b>Sint ista Graecorum;</b> Maximus dolor, inquit, brevis est. </p>

<p>Tollenda est atque extrahenda radicitus. Quorum sine causa fieri nihil putandum est. Quid est igitur, inquit, quod requiras? Cum praesertim illa perdiscere ludus esset. </p>

<ol>
	<li>Sit sane ista voluptas.</li>
	<li>Aut, Pylades cum sis, dices te esse Orestem, ut moriare pro amico?</li>
	<li>Estne, quaeso, inquam, sitienti in bibendo voluptas?</li>
	<li>Apud ceteros autem philosophos, qui quaesivit aliquid, tacet;</li>
	<li>Laelius clamores sofòw ille so lebat Edere compellans gumias ex ordine nostros.</li>
	<li>Itaque e contrario moderati aequabilesque habitus, affectiones ususque corporis apti esse ad naturam videntur.</li>
</ol>


<ul>
	<li>Quid est, quod ab ea absolvi et perfici debeat?</li>
	<li>An potest, inquit ille, quicquam esse suavius quam nihil dolere?</li>
	<li>Dat enim intervalla et relaxat.</li>
	<li>Prioris generis est docilitas, memoria;</li>
	<li>Neque solum ea communia, verum etiam paria esse dixerunt.</li>
</ul>


<blockquote cite='http://loripsum.net'>
	Idem fecisset Epicurus, si sententiam hanc, quae nunc Hieronymi est, coniunxisset cum Aristippi vetere sententia.
</blockquote>
HTML;
            $ElementContent->write();
            DB::alteration_message('ElementContent #2 for BlogPost #1 created', 'created');

            $CMSEditLink = $FirstBlog->CMSEditLink();
            DB::alteration_message("[PUBLISHED DATE: UNSET] - BlogPost #1 - EDIT HERE: <a href='$CMSEditLink' target='_blank'>$CMSEditLink</a>" , 'error');

            $ShareTokenLink = $FirstBlog->ShareTokenLink();
            DB::alteration_message("[PUBLISHED DATE: UNSET] - BlogPost #1 - PREVIEW here without PATCH: <a href='$ShareTokenLink' target='_blank'>$ShareTokenLink</a>" , 'error');
            DB::alteration_message("[PUBLISHED DATE: UNSET] - BlogPost #1 - PREVIEW here WITH PATCH: <a href='$ShareTokenLink?TEST_PATCH=enabled' target='_blank'>$ShareTokenLink?TEST_PATCH=enabled</a>" , 'error');

            /**
             * PUBLISHED DATE - FUTURE
             */
            $ElementalArea = new ElementalArea();
            $ElementalArea->OwnerClassName = BlogPost::class;
            $ElementalArea->write();
            DB::alteration_message('ElementalArea for BlogPost #2 created', 'created');

            $SecondBlog = new BlogPost();
            $SecondBlog->ParentID = $FirstArticleHolder->ID;
            $SecondBlog->ElementalAreaID = $ElementalArea->ID;
            $SecondBlog->Title = 'FUTURE PublishedDate';
            $SecondBlog->Content = <<<HTML
<h3>Without the patch, associated Elemental Blocks will appear below for:</h3>
<ul>
<li>Logged-in users: <strong style="color:green;">YES</strong></li>
<li>Logged-out users: <strong style="color:red;">NO</strong></li>
</ul>
HTML;
            $SecondBlog->PublishDate = DBDatetime::now()->modify('+1 year')->getValue();
            $SecondBlog->write();
            DB::alteration_message('BlogPost #2 for Articles created', 'created');

            $ElementContent = new ElementContent();
            $ElementContent->Sort = 1;
            $ElementContent->ParentID = $ElementalArea->ID;
            $ElementContent->ShowTitle = true;
            $ElementContent->Title = 'This is an ElementContent block with a visible Title and HTML content';
            $ElementContent->HTML = <<<HTML
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Res enim concurrent contrariae. <mark>Non semper, inquam;</mark> </p>

<ol>
	<li>Nihil est enim, de quo aliter tu sentias atque ego, modo commutatis verbis ipsas res conferamus.</li>
	<li>Facit enim ille duo seiuncta ultima bonorum, quae ut essent vera, coniungi debuerunt;</li>
</ol>


<blockquote cite='http://loripsum.net'>
	Aut, si nihil malum, nisi quod turpe, inhonestum, indecorum, pravum, flagitiosum, foedum-ut hoc quoque pluribus nominibus insigne faciamus-, quid praeterea dices esse fugiendum?
</blockquote>


<ul>
	<li>In qua quid est boni praeter summam voluptatem, et eam sempiternam?</li>
	<li>Ab his oratores, ab his imperatores ac rerum publicarum principes extiterunt.</li>
	<li>Ut optime, secundum naturam affectum esse possit.</li>
	<li>Ego quoque, inquit, didicerim libentius si quid attuleris, quam te reprehenderim.</li>
</ul>


<p><b>Omnia peccata paria dicitis.</b> Si longus, levis. Duo Reges: constructio interrete. Idem adhuc; <b>Confecta res esset.</b> </p>
HTML;
            $ElementContent->write();
            DB::alteration_message('ElementContent #1 for BlogPost #2 created', 'created');

            $ElementContent = new ElementContent();
            $ElementContent->Sort = 2;
            $ElementContent->ParentID = $ElementalArea->ID;
            $ElementContent->ShowTitle = true;
            $ElementContent->Title = 'A second ElementContent block';
            $ElementContent->HTML = <<<HTML
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tu quidem reddes; Negare non possum. Duo Reges: constructio interrete. <b>Sint ista Graecorum;</b> Maximus dolor, inquit, brevis est. </p>

<p>Tollenda est atque extrahenda radicitus. Quorum sine causa fieri nihil putandum est. Quid est igitur, inquit, quod requiras? Cum praesertim illa perdiscere ludus esset. </p>

<ol>
	<li>Sit sane ista voluptas.</li>
	<li>Aut, Pylades cum sis, dices te esse Orestem, ut moriare pro amico?</li>
	<li>Estne, quaeso, inquam, sitienti in bibendo voluptas?</li>
	<li>Apud ceteros autem philosophos, qui quaesivit aliquid, tacet;</li>
	<li>Laelius clamores sofòw ille so lebat Edere compellans gumias ex ordine nostros.</li>
	<li>Itaque e contrario moderati aequabilesque habitus, affectiones ususque corporis apti esse ad naturam videntur.</li>
</ol>


<ul>
	<li>Quid est, quod ab ea absolvi et perfici debeat?</li>
	<li>An potest, inquit ille, quicquam esse suavius quam nihil dolere?</li>
	<li>Dat enim intervalla et relaxat.</li>
	<li>Prioris generis est docilitas, memoria;</li>
	<li>Neque solum ea communia, verum etiam paria esse dixerunt.</li>
</ul>


<blockquote cite='http://loripsum.net'>
	Idem fecisset Epicurus, si sententiam hanc, quae nunc Hieronymi est, coniunxisset cum Aristippi vetere sententia.
</blockquote>
HTML;
            $ElementContent->write();
            DB::alteration_message('ElementContent #2 for BlogPost #2 created', 'created');

            $CMSEditLink = $SecondBlog->CMSEditLink();
            DB::alteration_message("[PUBLISHED DATE: FUTURE] - BlogPost #2 - EDIT HERE: <a href='$CMSEditLink' target='_blank'>$CMSEditLink</a>" , 'error');

            $ShareTokenLink = $SecondBlog->ShareTokenLink();
            DB::alteration_message("[PUBLISHED DATE: FUTURE] - BlogPost #2 - PREVIEW here without PATCH: <a href='$ShareTokenLink' target='_blank'>$ShareTokenLink</a>" , 'error');
            DB::alteration_message("[PUBLISHED DATE: FUTURE] - BlogPost #2 - PREVIEW here WITH PATCH: <a href='$ShareTokenLink?TEST_PATCH=enabled' target='_blank'>$ShareTokenLink?TEST_PATCH=enabled</a>" , 'error');

            /**
             * PUBLISHED DATE - PAST
             */
            $ElementalArea = new ElementalArea();
            $ElementalArea->OwnerClassName = BlogPost::class;
            $ElementalArea->write();
            DB::alteration_message('ElementalArea for BlogPost #3 created', 'created');

            $ThirdBlog = new BlogPost();
            $ThirdBlog->ParentID = $FirstArticleHolder->ID;
            $ThirdBlog->ElementalAreaID = $ElementalArea->ID;
            $ThirdBlog->Title = 'PAST PublishedDate';
            $ThirdBlog->Content = <<<HTML
<h3>Without the patch, associated Elemental Blocks will appear below for:</h3>
<ul>
<li>Logged-in users: <strong style="color:green;">YES</strong></li>
<li>Logged-out users: <strong style="color:green;">YES</strong></li>
</ul>
HTML;
            $ThirdBlog->PublishDate = DBDatetime::now()->modify('-1 year')->getValue();
            $ThirdBlog->write();
            DB::alteration_message('BlogPost #3 for Articles created', 'created');

            $ElementContent = new ElementContent();
            $ElementContent->Sort = 1;
            $ElementContent->ParentID = $ElementalArea->ID;
            $ElementContent->ShowTitle = true;
            $ElementContent->Title = 'This is an ElementContent block with a visible Title and HTML content';
            $ElementContent->HTML = <<<HTML
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Res enim concurrent contrariae. <mark>Non semper, inquam;</mark> </p>

<ol>
	<li>Nihil est enim, de quo aliter tu sentias atque ego, modo commutatis verbis ipsas res conferamus.</li>
	<li>Facit enim ille duo seiuncta ultima bonorum, quae ut essent vera, coniungi debuerunt;</li>
</ol>


<blockquote cite='http://loripsum.net'>
	Aut, si nihil malum, nisi quod turpe, inhonestum, indecorum, pravum, flagitiosum, foedum-ut hoc quoque pluribus nominibus insigne faciamus-, quid praeterea dices esse fugiendum?
</blockquote>


<ul>
	<li>In qua quid est boni praeter summam voluptatem, et eam sempiternam?</li>
	<li>Ab his oratores, ab his imperatores ac rerum publicarum principes extiterunt.</li>
	<li>Ut optime, secundum naturam affectum esse possit.</li>
	<li>Ego quoque, inquit, didicerim libentius si quid attuleris, quam te reprehenderim.</li>
</ul>


<p><b>Omnia peccata paria dicitis.</b> Si longus, levis. Duo Reges: constructio interrete. Idem adhuc; <b>Confecta res esset.</b> </p>
HTML;
            $ElementContent->write();
            DB::alteration_message('ElementContent #1 for BlogPost #3 created', 'created');

            $ElementContent = new ElementContent();
            $ElementContent->Sort = 2;
            $ElementContent->ParentID = $ElementalArea->ID;
            $ElementContent->ShowTitle = true;
            $ElementContent->Title = 'A second ElementContent block';
            $ElementContent->HTML = <<<HTML
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tu quidem reddes; Negare non possum. Duo Reges: constructio interrete. <b>Sint ista Graecorum;</b> Maximus dolor, inquit, brevis est. </p>

<p>Tollenda est atque extrahenda radicitus. Quorum sine causa fieri nihil putandum est. Quid est igitur, inquit, quod requiras? Cum praesertim illa perdiscere ludus esset. </p>

<ol>
	<li>Sit sane ista voluptas.</li>
	<li>Aut, Pylades cum sis, dices te esse Orestem, ut moriare pro amico?</li>
	<li>Estne, quaeso, inquam, sitienti in bibendo voluptas?</li>
	<li>Apud ceteros autem philosophos, qui quaesivit aliquid, tacet;</li>
	<li>Laelius clamores sofòw ille so lebat Edere compellans gumias ex ordine nostros.</li>
	<li>Itaque e contrario moderati aequabilesque habitus, affectiones ususque corporis apti esse ad naturam videntur.</li>
</ol>


<ul>
	<li>Quid est, quod ab ea absolvi et perfici debeat?</li>
	<li>An potest, inquit ille, quicquam esse suavius quam nihil dolere?</li>
	<li>Dat enim intervalla et relaxat.</li>
	<li>Prioris generis est docilitas, memoria;</li>
	<li>Neque solum ea communia, verum etiam paria esse dixerunt.</li>
</ul>


<blockquote cite='http://loripsum.net'>
	Idem fecisset Epicurus, si sententiam hanc, quae nunc Hieronymi est, coniunxisset cum Aristippi vetere sententia.
</blockquote>
HTML;
            $ElementContent->write();
            DB::alteration_message('ElementContent #2 for BlogPost #3 created', 'created');

            $CMSEditLink = $ThirdBlog->CMSEditLink();
            DB::alteration_message("[PUBLISHED DATE: PAST] - BlogPost #3 - EDIT HERE: <a href='$CMSEditLink' target='_blank'>$CMSEditLink</a>" , 'error');

            $ShareTokenLink = $ThirdBlog->ShareTokenLink();
            DB::alteration_message("[PUBLISHED DATE: PAST] - BlogPost #3 - PREVIEW here without PATCH: <a href='$ShareTokenLink' target='_blank'>$ShareTokenLink</a>" , 'error');
            DB::alteration_message("[PUBLISHED DATE: PAST] - BlogPost #3 - PREVIEW here WITH PATCH: <a href='$ShareTokenLink?TEST_PATCH=enabled' target='_blank'>$ShareTokenLink?TEST_PATCH=enabled</a>" , 'error');

        }

    }
}



























