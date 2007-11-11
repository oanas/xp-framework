<?xml version="1.0" encoding="UTF-8"?>
<!--
 ! Overview page
 !
 ! $Id: master.xsl 4410 2004-12-18 18:19:28Z friebe $
 !-->
<xsl:stylesheet
 version="1.0"
 xmlns:exsl="http://exslt.org/common"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:func="http://exslt.org/functions"
 xmlns:php="http://php.net/xsl"
 xmlns:xp="http://xp-framework.net/xsl"
 extension-element-prefixes="func"
 exclude-result-prefixes="func php exsl xsl xp"
>

  <xsl:include href="layout.inc.xsl"/>
  <xsl:include href="news.inc.xsl"/>
  
  <xsl:template name="html-head">
    <link rel="shortcut icon" href="/common/favicon.ico" />
    <link rel="alternate" type="application/rss+xml" title="RSS Feed for XP Framework news" href="{concat('/rss/?c=', /formresult/current-category/@id)}"/>
  </xsl:template>
  
  <xsl:template name="content">
    <table id="main" cellpadding="0" cellspacing="10">
      <tr>
        <td id="content">
          <h1><xsl:value-of select="/formresult/current-category"/></h1>
          <xsl:apply-templates select="/formresult/pager"/>
    
          <xsl:for-each select="/formresult/entries/entry">
            <h2><a href="{xp:linkArticle(@id, @link, date)}"><xsl:value-of select="title"/></a></h2>
            <em>
              <xsl:for-each select="category"><xsl:value-of select="."/>, </xsl:for-each>
              <xsl:value-of select="xp:date(date)"/> 
              (<xsl:value-of select="num_comments"/> comments)
            </em>
            <p><xsl:apply-templates select="body"/></p>
            <xsl:if test="extended_length != 0"><br/>(<a href="{xp:linkArticle(@id, @link, date)}">more</a>)</xsl:if>
            <br/><br clear="all"/>
          </xsl:for-each>
          
          <xsl:apply-templates select="/formresult/pager"/>
        </td>
        <td id="context">
          <xsl:call-template name="context"/>
        </td>
      </tr>
    </table>
  </xsl:template>
  
  <xsl:template name="context">
    <xsl:apply-templates select="context-feed"/>
    <xsl:apply-templates select="/formresult/categories"/>
  </xsl:template>
  
  <xsl:template name="context-feed">
    <xsl:variable name="feed">/rss/<xsl:if test="/formresult/current-category">?c=<xsl:value-of select="/formresult/current-category/@id"/></xsl:if>
    </xsl:variable>
    <h3>
      <a href="{$feed}">
        <img align="right" src="/common/image/feed.png" border="0"/>
      </a>
      Subscribe
    </h3>
    You can subscribe to the XP framework's news by using <a href="{$feed}">RSS syndication</a>.
    <br clear="all"/>
  </xsl:template>
  
  <xsl:template match="categories">
    <h3>Categories</h3>
    <xsl:for-each select="category">
      <a href="{xp:linkCategory(@id, @link)}"><xsl:value-of select="."/></a><br/>
     </xsl:for-each> 
  </xsl:template>
</xsl:stylesheet>