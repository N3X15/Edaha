<?php
/*
 * This file is part of kusaba.
 *
 * kusaba is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * kusaba is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License along with
 * kusaba; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
/*
 * Section for building the news page
 * Last Updated: $Date$
 
 * @author 		$Author$

 * @package		kusaba
 * @subpackage	core

 * @version		$Revision$
 *
 */
 
if (!defined('KUSABA_RUNNING'))
{
  print "<h1>Access denied</h1>You cannot access this file directly.";
  die();
}

class public_core_index_news extends kxCmd {

  public function exec( kxEnv $environment ) {
  
    $dwoo_data['styles'] = explode(':', kxEnv::Get('kx:css:menustyles'));
    $dwoo_data['entries'] = $this->db->select("front")
                                     ->fields("front")
                                     ->condition("page", 0)
                                     ->orderBy("timestamp", "DESC")
                                     ->range(0, 1)
                                     ->execute()
                                     ->fetchAll();
    $dwoo_data['sections'] = $this->db->select("sections")
                                      ->fields("sections")
                                      ->orderBy("\"order\"")
                                      ->execute()
                                      ->fetchAll();
    $dwoo_data['boards'] = $this->db->select("boards")
                                    ->fields("boards")
                                    ->orderBy("section")
                                    ->orderBy("\"order\"")
                                    ->execute()
                                    ->fetchAll();

    // Get recent images
    $images = $this->db->select("post_files");
    $images->innerJoin("posts", "", "posts.id = post_files.id AND posts.boardid = post_files.boardid");
    $images = $images->fields("post_files", array("file", "file_type", "boardid", "thumb_w", "thumb_h"))
                     ->fields("posts", array("id", "parentid"))
                     ->condition("post_files.file", "", "!=")
                     ->orderBy("posts.timestamp", "DESC")
                     ->range(0,3)
                     ->execute()
                     ->fetchAll();
    $i = 0;
    if (count($images) > 0) {
      $results =  $this->db->select('boards')
                    ->fields('boards', array('name'))
                    ->where('id = ?')
                    ->range(0,1)
                    ->build();
      while ($i < count($images)) {
       $results->execute(array($images[$i]->boardid));
       $board= $results->fetchAll();
       $images[$i]->boardname = $board[0]->name;
       $i++;
      }
    }
    $dwoo_data['images'] = $images;

    kxTemplate::output("index", $dwoo_data);
  }
}