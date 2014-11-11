<?php

/**
* Control panel object
*
* @author       Richard E. Dye
* @copyright    3/31/2004
* @package      qbrt
*/
class controlPanel{

    /**
    * Constructor
    *
    * @param    $inparms    array   input parameters
    */
    function controlPanel($inparms){
        $_SESSION['global_currentOperator']='AND';
    }

    /**
    * Output the control panel
    *
    * Construct the control panel for output
    * @param    $inparms    array input parameters
    * @return   string  HTML for the control panel
    */
    function output($inparms){
 
        $outstring = "\n".'<script language="javascript">'."\n";
        $outstring .= "function newOperator(newOperator){\n";
        $outstring .= "    this.location='".$_SERVER['PHP_SELF']."?class=controlPanel&method=setOperator&parm_operator='+newOperator;\n";
        #$outstring .= "    alert(newOperator);\n";
        $outstring .= "}\n";
        $outstring .= "</script>\n\n";



        $outstring .= '<table border="1" width="100%" bgcolor="#ffffff">'."\n";
        $outstring .= "<tr>\n";

        $outstring .= '<form name="oselect" action="'.$_SERVER['PHP_SELF'].'" method="post" target="queryDisplay">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryDisplay" />'."\n";
        $outstring .= '<input type="hidden" name="method" value="changeOperator" />'."\n";
        $outstring .= '<td align="center" valign="middle">'."\n";        

        $outstring .= '<select name="parm_operator" onChange="javascript:newOperator(this[this.selectedIndex].value)">'."\n";


        $outstring .= '<option value="AND"';
        if ($_SESSION['global_currentOperator'] == 'AND')
            $outstring .= ' selected';
        $outstring .= '>AND</option>'."\n";

        $outstring .= '<option value="OR"';
        if ($_SESSION['global_currentOperator'] == 'OR')
            $outstring .= ' selected';
        $outstring .= '>OR</option>'."\n";

        $outstring .= '<option value="NOT"';
        if ($_SESSION['global_currentOperator'] == 'NOT')
            $outstring .= ' selected';
        $outstring .= '>NOT</option>'."\n";


        $outstring .= '</select>'."\n";

        $outstring .= '<input type="submit" value="Change" />'."\n";

        $outstring .= "</td>\n";
        $outstring .= "</form>";
        $outstring .= "</tr>\n";

        $outstring .= "<tr>\n";
        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="_top">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryPerform" />'."\n";
        $outstring .= '<input type="hidden" name="method" value="createReport" />'."\n";
        $outstring .= '<input type="hidden" name="parm_assets" value="assets" />'."\n";
        $outstring .= '<input type="hidden" name="parm_products" value="products" />'."\n";
        $outstring .= '<input type="hidden" name="parm_query" value="queryDisplay" />'."\n";
        $outstring .= '<td align="center" valign="middle"><input type="submit" value="Perform query" /></td>'."\n";
        $outstring .= "</form>";
        $outstring .= "</tr>\n";

        $outstring .= "<tr><td>\n";
        $outstring .= '<table border="0">'."\n";
        $outstring .= "<tr>\n";


        # Insert a left parenthesis
        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="queryDisplay">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryDisplay" />'."\n";
        $outstring .= '<input type="hidden" name="method" value="insertParen" />'."\n";
        $outstring .= '<input type="hidden" name="parm_ptype" value="open" />'."\n";
        $outstring .= '<td><input type="submit" value=" +( " /></td>'."\n";
        $outstring .= "</form>";

        # Delete a left parenthesis
        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="queryDisplay">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryDisplay" />'."\n";
        $outstring .= '<input type="hidden" name="method" value="deleteParen" />'."\n";
        $outstring .= '<input type="hidden" name="parm_ptype" value="open" />'."\n";
        $outstring .= '<td><input type="submit" value=" -( " /></td>'."\n";
        $outstring .= "</form>";

        $outstring .= '<td align="center" valign="middle" width="100%">Parentheses</td>';

        # Delete a right parenthesis
        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="queryDisplay">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryDisplay" />'."\n";
        $outstring .= '<input type="hidden" name="method" value="deleteParen" />'."\n";
        $outstring .= '<input type="hidden" name="parm_ptype" value="close" />'."\n";
        $outstring .= '<td><input type="submit" value=" -) " /></td>'."\n";
        $outstring .= "</form>";


        # Insert a right parenthesis
        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="queryDisplay">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryDisplay" />'."\n";
        $outstring .= '<input type="hidden" name="method" value="insertParen" />'."\n";
        $outstring .= '<input type="hidden" name="parm_ptype" value="close" />'."\n";
        $outstring .= '<td><input type="submit" value=" +) " /></td>'."\n";
        $outstring .= "</form>";




        $outstring .= "</tr>\n";
        $outstring .= "</table>\n";
        $outstring .= "</td></tr>\n";

        $outstring .= "<tr>\n";
        $outstring .= '<td><table border="0" width="100%">'."\n";
        $outstring .= "<tr>\n";
        
        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="queryDisplay">'."\n";
        $outstring .= '<td align="center" valign="middle">'."\n";
        $outstring .= '<input type="hidden" name="class" value="queryDisplay">'."\n";
        $outstring .= '<input type="hidden" name="method" value="clearQuery">'."\n";
        $outstring .= '<input type="submit" value="Clear query">'."\n";
        $outstring .= "</td>\n";
        $outstring .= "</form>";

        $outstring .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post" target="_top">'."\n";
        $outstring .= '<td align="center" valign="middle">'."\n";
        $outstring .= '<input type="hidden" name="class" value="qbrt_EXIT">'."\n";
        $outstring .= '<input type="submit" value="EXIT">'."\n";
        $outstring .= "</td>\n";
        $outstring .= "</form>";

        $outstring .= "</tr>\n";
        $outstring .= "</table></td>\n";
        $outstring .= "</tr>\n";

        $outstring .= "</table>\n";

        return $outstring;
    }

    /**
    * Set the current boolean logical operator
    *
    * @param    $inparms    array input parameters
    * @return   string  HTML for the control panel
    */
    function setOperator($inparms){
        $_SESSION['global_currentOperator']=$inparms['operator'];

        return $this->output(NULL);
    }
}
?>
