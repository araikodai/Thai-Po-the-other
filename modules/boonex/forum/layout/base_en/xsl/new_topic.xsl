<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">

<xsl:include href="rewrite.xsl" />

<xsl:template match="urls" />

<xsl:template match="new_topic">


    <xsl:call-template name="breadcrumbs">
        <xsl:with-param name="link1">
            <a href="{$rw_cat}{cat/uri}{$rw_cat_ext}" onclick="return f.selectForumIndex('{cat/uri}')"><xsl:value-of select="cat/title" disable-output-escaping="yes" /></a>
        </xsl:with-param>
        <xsl:with-param name="link2">
            <a href="{$rw_forum}{forum/uri}{$rw_forum_page}0{$rw_forum_ext}" onclick="return f.selectForum('{forum/uri}', 0);"><xsl:value-of select="forum/title" disable-output-escaping="yes" /></a>
        </xsl:with-param>
    </xsl:call-template>

    <xsl:call-template name="box">
        <xsl:with-param name="title"><xsl:value-of select="forum/title" disable-output-escaping="yes" /></xsl:with-param>
        <xsl:with-param name="content">

            <div class="bx-def-bc-padding">

                <form action="{/root/urls/base}" enctype="multipart/form-data" name="new_topic" method="post" target="post_new_topic" onsubmit="return f.checkPostTopicValues(this.topic_subject, this.topic_text, this.signature, this.forum, true);">

					<input type="hidden" name="action" value="post_new_topic" />
                    <input type="hidden" name="forum_id" value="{forum/id}" />

                    <div class="bx-def-margin-bottom">
                        Forum:
                        <div class="forum_field_error_message" style="display:none" id="err_forum">Please select forum to post topic in</div>
                        <div>
                            <select class="forum_form_field bx-def-font-large bx-def-round-corners-with-border" name="forum">
                                <option value="0">Select Forum</option>
                                <xsl:apply-templates select="categs" />
                            </select>
                        </div>
                    </div>


                    <div class="bx-def-margin-bottom">
                       Topic subject: 
                        <div class="forum_field_error_message" style="display:none" id="err_topic_subject">Please enter from 5 to 50 symbols</div>
                        <div>
                            <input class="forum_form_field bx-def-font-large bx-def-round-corners-with-border" type="text" name="topic_subject" size="50" maxlength="50" /> 
                        </div>
                    </div>
					
					
					<xsl:if test="1 = @sticky">
                        <div class="bx-def-margin-bottom">
					        <span class="sticky"><input type="checkbox" name="topic_sticky" id="sticky" /><label for="sticky">Sticky</label></span>
                        </div>
					</xsl:if>

                    Topic text: 
                    <div class="forum_field_error_message" style="display:none" id="err_topic_text">Please enter from 5 to 128000 symbols</div>
					<textarea id="tinyEditor" name="topic_text" style="width:100%; height:316px;">&#160;</textarea>

                    <xsl:call-template name="attachments">
                        <xsl:with-param name="files"></xsl:with-param>
                    </xsl:call-template>

                    <xsl:call-template name="signature">
                        <xsl:with-param name="text" select="signature" />
                    </xsl:call-template>

					<div class="bx-def-margin-top">
                        <input type="submit" name="post_submit" value="Submit" onclick="tinyMCE.triggerSave(); if (!f.checkPostTopicValues(document.forms['new_topic'].topic_subject, document.forms['new_topic'].topic_text, document.forms['new_topic'].signature, document.forms['new_topic'].forum, true)) return false;" class="bx-btn" />
                        <input type="reset" name="cancel" value="Cancel" onclick="return f.cancelNewTopic('{forum/uri}', 0)" class="bx-btn" />
                        <div class="clear_both"></div>
					</div>

				</form>

                <iframe frameborder="0" border="0" name="post_new_topic" style="border:none; padding:0; margin:0; background-color:transparent; width:0px; height:0px;">&#160;</iframe>
    		</div>

        </xsl:with-param>
    </xsl:call-template>

</xsl:template>


<xsl:template match="categ">
	<xsl:element name="optgroup">
		<xsl:attribute name="label"><xsl:value-of select="title" /></xsl:attribute>
        <xsl:apply-templates select="forums/forum" />
	</xsl:element>
</xsl:template>

<xsl:template match="forum">
	<xsl:element name="option">
        <xsl:if test="@id = ./../../../../forum/id">
            <xsl:attribute name="selected">selected</xsl:attribute>
        </xsl:if>
		<xsl:attribute name="value"><xsl:value-of select="@id" /></xsl:attribute>
		<xsl:value-of select="title" />
    </xsl:element>
</xsl:template>

</xsl:stylesheet>


