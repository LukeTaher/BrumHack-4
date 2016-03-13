public class Sorter {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		int[] a = {5,1,3,5,6,1,3,4,16,13,64,23,7242,32};
		int[] b = sort(a);
		boolean works = true;
		for (int i = 0; i < a.length; i++) {
			if (a[i] != b[i]) {
				works = false;
				break;
			}
		}
		System.out.println(works);

	}
	public static int[] sort(int[] a) {
		for(int i = 0; i < a.length; i++)
			for(int j = 0; j < a.length; j++)
				if(a[i] > a[j]) {
					int temp = a[i];
					a[i] = a[j];
					a[j] = temp;
				}
		return a;
	}
}
