import java.util.ArrayList;

public class Recipe {
	int recipe_id;//なんで作ったか忘れた　たぶんいらない
	String recipe_url; //レシピページURL
	String recipe_image_url; //画像URL
	ArrayList<String> recipe_materials = new ArrayList<String>(); //食材をリストに入れる。
	String recipe_title; //recipeタイトル
}