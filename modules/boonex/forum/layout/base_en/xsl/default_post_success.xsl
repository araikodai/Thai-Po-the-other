<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">

<xsl:template match="/">

    <xsl:call-template name="box">
        <xsl:with-param name="title">New topic has been created</xsl:with-param>
        <xsl:with-param name="content">

            <div class="forum_centered_msg">
                <b>New topic has been created</b>
                <br />
                <a href="javascript:void(0);" onclick="f.selectForum('{forum/uri}', 0);">return to forum index</a>
            </div>

        </xsl:with-param>
    </xsl:call-template>

</xsl:template>

</xsl:stylesheet>


