import ListPreprocessPlugin from "../plugin/types/ListPreprocessPlugin";

@ListPreprocessPlugin.register()
export default class UserListPreprocess extends ListPreprocessPlugin {

	static preprocess(row) {
		if (row.status === 'active') row.status = '<i class="fas fa-user"></i>';
		else  row.status = '<i class="fal fa-user"></i>';
	}

}
