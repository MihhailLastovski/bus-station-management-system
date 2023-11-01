<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/bussid">
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Otsi..."/>
    <table class="buss-table">
      <tr>
        <th onclick="sortTable(0, 'marsruut')">Marsruut<span id="marsruutSortIcon" class="sort-icon"></span></th>
        <th onclick="sortTable(1, 'lähtepunkt')">Lähtepunkt<span id="lähtepunktSortIcon" class="sort-icon"></span></th>
        <th onclick="sortTable(2, 'sihtpunkt')">Sihtpunkt<span id="sihtpunktSortIcon" class="sort-icon"></span></th>
        <th onclick="sortTable(3, 'väljumisaeg')">Väljumisaeg<span id="väljumisaegSortIcon" class="sort-icon"></span></th>
      </tr>
      <xsl:apply-templates select="buss">
        <xsl:sort select="@marsruut" data-type="text" order="ascending" />
      </xsl:apply-templates>
    </table>
  </xsl:template>

  <xsl:template match="buss">
    <tr>
      <td><xsl:value-of select="@marsruut" /></td>
      <td><xsl:value-of select="lähtepunkt" /></td>
      <td><xsl:value-of select="sihtpunkt" /></td>
      <td><xsl:value-of select="väljumisaeg" /></td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
