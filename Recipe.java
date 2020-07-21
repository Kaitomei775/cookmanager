/** name 磯野
* date　2020.07.14
* purpose   recipeクラスを作成する。
* function　レシピクラスを作る。
* return none
* **/

import java.util.ArrayList;

public class Recipe {
	int recipe_id;//なんで作ったか忘れた　たぶんいらない
	String recipe_url; //レシピページURL
	String recipe_image_url; //画像URL
	ArrayList<String> recipe_materials = new ArrayList<String>(); //食材をリストに入れる。
	String recipe_title; //recipeタイトル
}